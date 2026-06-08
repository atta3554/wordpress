class MyNotes {
  constructor() {
    this.container = document.querySelector("#notes-container");

    if (!this.container) {
      return;
    }

    this.notesList = this.container.querySelector(".notes-list");
    this.currentEditingBox = null;
    this.event();
  }

  event() {
    this.container.addEventListener("click", (event) => {
      const deleteBtn = event.target.closest(".delete-note");
      const editBtn = event.target.closest(".edit-note");
      const cancelBtn = event.target.closest(".cancel-note");
      const submitBtn = event.target.closest(".submit-note");

      if (deleteBtn) this.deleteNote(deleteBtn);
      if (editBtn) this.editNote(editBtn);
      if (cancelBtn) this.cancelEdit(cancelBtn.closest(".note-box"));
      if (submitBtn) this.createNote(submitBtn);
    });
  }

  async deleteNote(button) {
    const noteBox = button.closest(".note-box");
    if (!noteBox) return;

    button.disabled = true;

    try {
      const response = await fetch(`${themeData.root_url}/wp-json/wp/v2/note/${noteBox.dataset.id}`, {
        method: "DELETE",
        headers: {
          "content-type": "application/json",
          "X-WP-Nonce": themeData.nonce,
        },
      });

      const data = await response.json();
      if (!response.ok) {
        throw new Error(data.message || "Unable to delete note.");
      }

      noteBox.classList.add("hide");
      this.showDeleteAlert();
      setTimeout(() => noteBox.remove(), 900);
    } catch (error) {
      window.alert(error.message);
      button.disabled = false;
    }
  }

  editNote(button) {
    const noteBox = button.closest(".note-box");
    if (!noteBox) return;

    if (this.currentEditingBox && this.currentEditingBox !== noteBox) {
      window.alert("Please finish your previous note editing first.");
      return;
    }

    if (!this.currentEditingBox) {
      this.makeNoteEditable(noteBox);
      return;
    }

    this.updateNote(noteBox);
  }

  makeNoteEditable(box) {
    const cancelNote = box.querySelector(".cancel-note");
    const currentNoteTitle = box.querySelector(".note-title");
    const currentNoteBody = box.querySelector(".note-body");
    const editButton = box.querySelector(".edit-note");

    box.dataset.originalTitle = currentNoteTitle.value;
    box.dataset.originalBody = currentNoteBody.value;

    cancelNote.classList.add("active");
    editButton.innerHTML = `<i class="fa fa-check me-2" aria-hidden="true"></i>Save`;

    currentNoteTitle.removeAttribute("readonly");
    currentNoteTitle.classList.add("active");
    currentNoteTitle.focus();

    currentNoteBody.removeAttribute("readonly");
    currentNoteBody.classList.add("active");

    this.currentEditingBox = box;
  }

  cancelEdit(box) {
    if (!box) return;

    box.querySelector(".note-title").value = box.dataset.originalTitle || "";
    box.querySelector(".note-body").value = box.dataset.originalBody || "";
    this.makeNoteReadableOnly(box);
  }

  makeNoteReadableOnly(box) {
    box.querySelector(".cancel-note").classList.remove("active");
    box.querySelector(".edit-note").innerHTML =
      `<i class="fa fa-pencil me-2" aria-hidden="true"></i>Edit`;

    box.querySelector(".note-title").setAttribute("readonly", true);
    box.querySelector(".note-title").classList.remove("active");

    box.querySelector(".note-body").setAttribute("readonly", true);
    box.querySelector(".note-body").classList.remove("active");

    delete box.dataset.originalTitle;
    delete box.dataset.originalBody;
    this.currentEditingBox = null;
  }

  async updateNote(box) {
    const editButton = box.querySelector(".edit-note");
    editButton.disabled = true;

    try {
      const response = await fetch(`${themeData.root_url}/wp-json/wp/v2/note/${box.dataset.id}`, {
        method: "POST",
        headers: {
          "content-type": "application/json",
          "X-WP-Nonce": themeData.nonce,
        },
        body: JSON.stringify({
          title: box.querySelector(".note-title").value,
          content: box.querySelector(".note-body").value,
          status: "private",
        }),
      });

      const data = await response.json();
      if (!response.ok) {
        throw new Error(data.message || "Unable to update note.");
      }

      this.makeNoteReadableOnly(box);
    } catch (error) {
      window.alert(error.message);
    } finally {
      editButton.disabled = false;
    }
  }

  async createNote(button) {
    const newNoteBox = button.closest(".new-note-box");
    const currentTitle = newNoteBox.querySelector(".note-title");
    const currentBody = newNoteBox.querySelector(".note-body");

    if (!currentTitle.value.trim() || !currentBody.value.trim()) {
      window.alert("Please enter a title and body for your note.");
      return;
    }

    button.disabled = true;
    this.showLoader(newNoteBox);

    try {
      const response = await fetch(`${themeData.root_url}/wp-json/wp/v2/note`, {
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
      });

      const data = await response.json();
      if (!response.ok) {
        throw new Error(data.message || "Unable to create note.");
      }

      this.makeNoteTemplate(currentTitle.value, currentBody.value, data.id);
      currentTitle.value = "";
      currentBody.value = "";
    } catch (error) {
      window.alert(error.message);
    } finally {
      this.hideLoader();
      button.disabled = false;
    }
  }

  makeNoteTemplate(title, body, id) {
    const emptyMessage = this.notesList.querySelector("p.text-center");
    if (emptyMessage) emptyMessage.remove();

    const noteBox = document.createElement("div");
    noteBox.className =
      "note-box border rounded py-4 my-5 col-12 col-sm-10 col-md-9 col-lg-6 col-xl-5 d-flex overflow-hidden flex-column";
    noteBox.dataset.id = id;

    const noteHeader = document.createElement("div");
    noteHeader.className =
      "d-flex flex-column-reverse flex-sm-row px-3 justify-content-between align-items-start align-items-sm-center";

    const titleInput = document.createElement("input");
    titleInput.readOnly = true;
    titleInput.className = "note-title px-3 py-2 my-3";
    titleInput.type = "text";
    titleInput.value = title;

    const actions = document.createElement("div");
    actions.className = "d-flex";

    const editBtn = document.createElement("button");
    editBtn.type = "button";
    editBtn.className = "edit-note border rounded px-2 mx-2 bg-transparent";
    editBtn.innerHTML = `<i class="fa fa-pencil me-2" aria-hidden="true"></i>Edit`;

    const deleteBtn = document.createElement("button");
    deleteBtn.type = "button";
    deleteBtn.className =
      "delete-note border rounded px-2 border-danger text-danger bg-transparent";
    deleteBtn.innerHTML = `<i class="fa fa-trash-o me-2" aria-hidden="true"></i>Delete`;

    const bodyTextarea = document.createElement("textarea");
    bodyTextarea.readOnly = true;
    bodyTextarea.className = "note-body p-3 w-100 overflow-auto";
    bodyTextarea.value = body;

    const footerRow = document.createElement("div");
    footerRow.className = "row";

    const cancelCol = document.createElement("div");
    cancelCol.className = "col-3";

    const cancelBtn = document.createElement("button");
    cancelBtn.type = "button";
    cancelBtn.className =
      "cancel-note mx-auto my-2 bg-primary text-white text-center rounded py-2 border-0";
    cancelBtn.innerHTML = `<i class="fa fa-close me-2" aria-hidden="true"></i>Cancel`;

    const errorCol = document.createElement("div");
    errorCol.className = "col-9";

    const errorMessage = document.createElement("span");
    errorMessage.className = "error-message";
    errorMessage.textContent =
      "Your notes count has reached the limit. Please delete a note.";

    actions.append(editBtn, deleteBtn);
    noteHeader.append(titleInput, actions);
    cancelCol.append(cancelBtn);
    errorCol.append(errorMessage);
    footerRow.append(cancelCol, errorCol);
    noteBox.append(noteHeader, bodyTextarea, footerRow);
    this.notesList.prepend(noteBox);
  }

  showDeleteAlert() {
    const alertContainer = document.querySelector(".delete-note__alert-container");
    const alertBg = document.querySelector(".delete-note__alert-bg");
    if (!alertContainer || !alertBg) return;

    setTimeout(() => alertContainer.classList.add("active"), 100);
    setTimeout(() => alertBg.classList.add("active"), 200);
    setTimeout(() => alertBg.classList.remove("active"), 1000);
    setTimeout(() => alertContainer.classList.remove("active"), 1500);
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
    const loader = document.getElementById("spinner-bg");
    if (loader) loader.remove();
  }
}

export default MyNotes;
