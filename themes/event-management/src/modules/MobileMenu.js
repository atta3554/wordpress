class MobileMenu {
  constructor() {
    this.menu = document.querySelector(".nav-container");
    this.openButton = document.querySelector(".humburgur-menu");
    this.openButtonIcon = this.openButton ? this.openButton.querySelector("i") : null;

    if (!this.menu || !this.openButton || !this.openButtonIcon) {
      return;
    }

    this.events();
  }

  events() {
    this.openButton.addEventListener("click", () => this.openMenu());
  }

  openMenu() {
    const isActive = this.menu.classList.toggle("active");
    this.openButton.setAttribute("aria-expanded", isActive ? "true" : "false");
    this.openButtonIcon.classList.toggle("fa-bars", !isActive);
    this.openButtonIcon.classList.toggle("fa-window-close", isActive);
  }
}

export default MobileMenu;
