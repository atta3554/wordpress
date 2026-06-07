class MyNotes {
  constructor() {
    if (document.querySelector("#notes-container")) {
      this.deleteNoteBtns = document.querySelectorAll(".delete-note");
      this.editNoteBtns = document.querySelectorAll(".edit-note");
      this.submitNote = document.querySelector(".submit-note");
      this.isEditing = false;
      this.event();
    }
  }

  event() {
    this.deleteNoteBtns.forEach((btn) => {
      btn.addEventListener("click", (event) => this.deleteNote(event));
    });

    this.editNoteBtns.forEach((btn) => {
      btn.addEventListener("click", (event) => this.editNote(event));
    });

    this.submitNote.addEventListener("click", (event) =>
      this.createNote(event),
    );
  }

  deleteNote(event) {
    let noteBox;
    event.target.innerHTML.includes("Delete")
      ? (noteBox = event.target.parentElement.parentElement.parentElement)
      : (noteBox =
          event.target.parentElement.parentElement.parentElement.parentElement);

    fetch(
      `${themeData.root_url}/wp-json/wp/v2/note/${noteBox.getAttribute(
        "data-id",
      )}`,
      {
        method: "DELETE",
        headers: {
          "content-type": "application/json",
          "X-WP-Nonce": themeData.nonce,
        },
      },
    ).then((res) => {
      noteBox.classList.add("hide");
      setTimeout(() => {
        document
          .querySelector(".delete-note__alert-container")
          .classList.add("active");
      }, 100);
      setTimeout(() => {
        document
          .querySelector(".delete-note__alert-bg")
          .classList.add("active");
      }, 200);
      setTimeout(() => {
        document
          .querySelector(".delete-note__alert-bg")
          .classList.remove("active");
      }, 1000);
      setTimeout(() => {
        document
          .querySelector(".delete-note__alert-container")
          .classList.remove("active");
      }, 1500);
    });
  }

  editNote(event) {
    let noteBox;
    if (
      this.isEditing &&
      (event.target.innerHTML.includes("Edit") ||
        event.target.parentElement.innerHTML.includes("Edit"))
    )
      alert("please finish your previous note editing first");
    else {
      [...event.target.classList].includes("fa-pencil") ||
      [...event.target.classList].includes("fa-check")
        ? (noteBox =
            event.target.parentElement.parentElement.parentElement
              .parentElement)
        : (noteBox = event.target.parentElement.parentElement.parentElement);

      if (!this.isEditing) {
        this.makeNoteEditable(noteBox);
      } else {
        this.updateNote(noteBox);
      }
    }
  }

  makeNoteEditable(box) {
    let cancelNote = box.querySelector(".cancel-note");
    let currentNoteTitle = box.querySelector(".note-title");
    let currentNoteBody = box.querySelector(".note-body");

    cancelNote.classList.add("active");
    cancelNote.addEventListener("click", () => this.cancelEdit(box));

    box.querySelector(
      ".edit-note",
    ).innerHTML = `<i class='fa fa-check me-2' aria-hidden='true'></i>Save`;

    currentNoteTitle.removeAttribute("readonly");
    currentNoteTitle.classList.add("active");

    currentNoteBody.removeAttribute("readonly");
    currentNoteBody.classList.add("active");

    this.isEditing = true;
  }

  cancelEdit(box) {
    this.makeNoteReadbaleOnly(box);
    let prevTitle = box.querySelector(".note-title").value;
    let prevBody = box.querySelector(".note-body").value;

    box.querySelector(".note-title").value = prevTitle;
    box.querySelector(".note-body").value = prevBody;
  }

  makeNoteReadbaleOnly(box) {
    box.querySelector(".cancel-note").classList.remove("active");
    box.querySelector(
      ".edit-note",
    ).innerHTML = `<i class='fa fa-pencil me-2' aria-hidden='true'></i>Edit`;

    box.querySelector(".note-title").setAttribute("readonly", true);
    box.querySelector(".note-title").classList.remove("active");

    box.querySelector(".note-body").setAttribute("readonly", true);
    box.querySelector(".note-body").classList.remove("active");

    this.isEditing = false;
  }

  updateNote(box) {
    fetch(
      `${themeData.root_url}/wp-json/wp/v2/note/${box.getAttribute("data-id")}`,
      {
        method: "POST",
        headers: {
          "content-type": "application/json",
          "X-WP-Nonce": themeData.nonce,
        },
        body: JSON.stringify({
          title: box.querySelector(".note-title").value,
          content: box.querySelector(".note-body").value,
        }),
      },
    )
      .then((res) => res.json())
      .then((data) => this.makeNoteReadbaleOnly(box));
  }

  createNote(event) {
    let submitBtn = event.target.parentElement;
    let currentTitle = submitBtn.previousElementSibling.previousElementSibling;
    let currentBody = submitBtn.previousElementSibling;

    this.showLoader(submitBtn.closest(".row"));

    fetch(`${themeData.root_url}/wp-json/wp/v2/note`, {
      method: "POST",
      headers: {
        "content-type": "application/json",
        "X-WP-Nonce": themeData.nonce,
      },
      body: JSON.stringify({
        title: currentTitle.value,
        content: currentBody.value,
        status: "private",
      }),
    })
      .then((res) => res.json())
      .then((data) => {
        if (
          (data.error &&
            data.error === "limit note count! delete some notes first") ||
          data.code === "note_limit_reached"
        ) {
          alert(
            "you have reached your limit notes count! please delete one first in order to create another",
          );
        } else this.makeNoteTemplate(event, currentTitle, currentBody, data.id);

        this.hideLoader();
      });
  }

  makeNoteTemplate(event, title, body, id) {
    const notesList = event.target.closest(".row").nextElementSibling;
    const noteBox = document.createElement("div");
    noteBox.className =
      "note-box border rounded mx-5 py-4 my-5 col-5 d-flex overflow-hidden flex-column";
    noteBox.dataset.id = id;

    const noteHeader = document.createElement("div");
    noteHeader.className =
      "d-flex px-3 justify-content-between align-items-center";

    const titleInput = document.createElement("input");
    titleInput.readOnly = true;
    titleInput.className = "note-title px-3 py-2 my-3";
    titleInput.type = "text";
    titleInput.value = title.value;

    const actions = document.createElement("div");
    actions.className = "d-flex";

    const editBtn = document.createElement("span");
    editBtn.role = "button";
    editBtn.className = "edit-note border rounded px-2 mx-2";
    editBtn.innerHTML = `<i class='fa fa-pencil me-2' aria-hidden="true"></i>Edit`;

    const deleteBtn = document.createElement("span");
    deleteBtn.role = "button";
    deleteBtn.className =
      "delete-note border rounded px-2 border-danger text-danger";
    deleteBtn.innerHTML = `<i class='fa fa-trash-o me-2' aria-hidden="true"></i>Delete`;

    const bodyTextarea = document.createElement("textarea");
    bodyTextarea.readOnly = true;
    bodyTextarea.className = "note-body p-3 w-100 overflow-auto";
    bodyTextarea.value = body.value;

    const footerRow = document.createElement("div");
    footerRow.className = "row";

    const cancelCol = document.createElement("div");
    cancelCol.className = "col-3";

    const cancelBtn = document.createElement("span");
    cancelBtn.role = "button";
    cancelBtn.className =
      "cancel-note mx-auto my-2 bg-primary text-white text-center rounded py-2";
    cancelBtn.innerHTML = `<i class='fa fa-close me-2' aria-hidden='true'></i>Cancel`;

    const errorCol = document.createElement("div");
    errorCol.className = "col-9";

    const errorMessage = document.createElement("span");
    errorMessage.className = "error-message";
    errorMessage.textContent =
      "your notes count has reached to Limit; please delete a note";

    actions.append(editBtn, deleteBtn);
    noteHeader.append(titleInput, actions);
    cancelCol.append(cancelBtn);
    errorCol.append(errorMessage);
    footerRow.append(cancelCol, errorCol);
    noteBox.append(noteHeader, bodyTextarea, footerRow);
    notesList.prepend(noteBox);

    editBtn.addEventListener("click", (event) => this.editNote(event));
    deleteBtn.addEventListener("click", (event) => this.deleteNote(event));

    title.value = "";
    body.value = "";
  }

  showLoader(container) {
    const loaderBg = document.createElement("div");
    loaderBg.id = "spinner-bg";

    const loader = document.createElement("div");
    loader.classList.add("spinner");

    loaderBg.appendChild(loader);
    container.appendChild(loaderBg);
  }

  hideLoader() {
    document.getElementById("spinner-bg").remove();
  }
}

export default MyNotes;
