class MobileMenu {
  constructor() {
    console.log('selam');
    this.menu = document.querySelector(".nav-container")
    this.openButton = document.querySelector(".humburgur-menu i")
    this.events()
  }

  events() {
    this.openButton.addEventListener("click", () => this.openMenu())
  }

  openMenu() {
    this.openButton.classList.toggle("fa-bars")
    this.openButton.classList.toggle("fa-window-close")
    this.menu.classList.toggle("active")
  }
}

export default MobileMenu
