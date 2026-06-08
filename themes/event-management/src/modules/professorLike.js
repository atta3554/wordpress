class Like {
  constructor() {
    this.likeWrapper = document.querySelector(".professor-likes");

    if (!this.likeWrapper) {
      return;
    }

    this.likeBtn = this.likeWrapper.querySelector(".like-area");
    this.likesCount = this.likeWrapper.querySelector(".likes-count");
    this.likeIcon = this.likeWrapper.querySelector(".like-btn i");

    if (!this.likeBtn || !this.likesCount || !this.likeIcon) {
      return;
    }

    this.event();
  }

  event() {
    this.likeBtn.addEventListener("click", () => this.checkStatus());
  }

  checkStatus() {
    if (this.likeBtn.disabled) {
      window.alert("Please log in to like professors.");
      return;
    }

    const isLiked = this.likeWrapper.getAttribute("data-exist") === "yes";

    if (isLiked) {
      this.disLikeProfessor();
    } else {
      this.likeProfessor();
    }
  }

  async likeProfessor() {
    this.likeBtn.disabled = true;

    try {
      const response = await fetch(`${themeData.root_url}/wp-json/ataRoute/v1/like`, {
        method: "POST",
        headers: {
          "content-type": "application/json",
          "X-WP-Nonce": themeData.nonce,
        },
        body: JSON.stringify({
          professorId: this.likeWrapper.getAttribute("data-professor"),
        }),
      });

      const data = await response.json();

      if (!response.ok) {
        throw new Error(data.message || "Unable to like this professor.");
      }

      this.likesCount.textContent = String(Number(this.likesCount.textContent) + 1);
      this.likeWrapper.setAttribute("data-exist", "yes");
      this.likeWrapper.setAttribute("data-like", data.id);
      this.likeIcon.classList.remove("fa-regular");
      this.likeIcon.classList.add("fa-solid");
    } catch (error) {
      window.alert(error.message);
    } finally {
      this.likeBtn.disabled = false;
    }
  }

  async disLikeProfessor() {
    this.likeBtn.disabled = true;

    try {
      const response = await fetch(`${themeData.root_url}/wp-json/ataRoute/v1/like`, {
        method: "DELETE",
        headers: {
          "content-type": "application/json",
          "X-WP-Nonce": themeData.nonce,
        },
        body: JSON.stringify({
          like: this.likeWrapper.getAttribute("data-like"),
        }),
      });

      const data = await response.json();

      if (!response.ok) {
        throw new Error(data.message || "Unable to remove this like.");
      }

      this.likesCount.textContent = String(Math.max(0, Number(this.likesCount.textContent) - 1));
      this.likeWrapper.setAttribute("data-exist", "no");
      this.likeWrapper.removeAttribute("data-like");
      this.likeIcon.classList.remove("fa-solid");
      this.likeIcon.classList.add("fa-regular");
    } catch (error) {
      window.alert(error.message);
    } finally {
      this.likeBtn.disabled = false;
    }
  }
}

export default Like;
