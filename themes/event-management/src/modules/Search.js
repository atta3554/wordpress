class Search {
  constructor() {
    this.openSearchButton = document.querySelector(".search-icon a");
    this.isOverlayOpen = false;
    this.isSpinnerLoading = false;
    this.debounceTimer = null;

    if (!this.openSearchButton || !document.querySelector("header")) {
      return;
    }

    this.showSearchOverlay();
    this.closeSearchButton = document.querySelector(".close-search-icon");
    this.searchBox = document.querySelector(".search-overlay");
    this.searchInp = document.querySelector(".search-input");
    this.searchResults = document.querySelector(".search-results");

    if (!this.closeSearchButton || !this.searchBox || !this.searchInp || !this.searchResults) {
      return;
    }

    this.eventsHandler();
  }

  eventsHandler() {
    this.openSearchButton.addEventListener("click", (event) => this.openSearchBox(event));
    this.closeSearchButton.addEventListener("click", () => this.closeSearchBox());
    this.searchInp.addEventListener("input", () => this.getUserText());
    window.addEventListener("keyup", (event) => {
      if (event.key === "Escape" && this.isOverlayOpen) this.closeSearchBox();
    });
  }

  openSearchBox(event) {
    event.preventDefault();
    this.searchInp.value = "";
    this.searchResults.innerHTML = "";

    if (!this.isOverlayOpen) {
      this.searchBox.classList.add("active");
      this.searchBox.setAttribute("aria-hidden", "false");
      document.body.classList.add("overflow-hidden");
      this.isOverlayOpen = true;

      setTimeout(() => {
        this.searchInp.focus();
      }, 301);
    }
  }

  closeSearchBox() {
    if (this.isOverlayOpen) {
      this.searchBox.classList.remove("active");
      this.searchBox.setAttribute("aria-hidden", "true");
      document.body.classList.remove("overflow-hidden");
      this.isOverlayOpen = false;
    }
  }

  getUserText() {
    const keyword = this.searchInp.value.trim();
    clearTimeout(this.debounceTimer);

    if (keyword.length < 2) {
      this.searchResults.innerHTML = "<p class='text-center'>Type at least 2 characters.</p>";
      this.isSpinnerLoading = false;
      return;
    }

    if (!this.isSpinnerLoading) {
      this.searchResults.innerHTML = '<div class="search-spinner"></div>';
      this.isSpinnerLoading = true;
    }

    this.debounceTimer = setTimeout(() => this.fetchData(keyword), 450);
  }

  async fetchData(keyword) {
    try {
      const response = await fetch(
        `${themeData.root_url}/wp-json/ataRoute/v1/search?keyword=${encodeURIComponent(keyword)}`,
      );

      if (!response.ok) {
        throw new Error("Search request failed");
      }

      const data = await response.json();
      this.renderResults(data);
    } catch (error) {
      this.searchResults.innerHTML =
        "<p class='text-center text-danger'>Search is temporarily unavailable.</p>";
    } finally {
      this.isSpinnerLoading = false;
    }
  }

  renderResults(data) {
    const sections = {
      pages: "pages",
      posts: "posts",
      events: "events",
      professors: "professors",
      seminars: "seminars",
    };

    const html = Object.keys(sections)
      .map((postType) => {
        const items = Array.isArray(data[postType]) ? data[postType] : [];

        if (!items.length) {
          return `
            <h4 class="text-center">Nothing matches your search through ${this.escapeHTML(sections[postType])}${
              postType !== "pages"
                ? ` <a class="text-primary" href="${this.escapeAttr(
                    `${themeData.root_url}/${postType === "posts" ? "blog" : postType}`,
                  )}">See all ${this.escapeHTML(sections[postType])}<i class="fa-solid fa-arrow-right"></i></a>`
                : ""
            }</h4><hr>`;
        }

        return `
          <h2 class="text-center">From our ${this.escapeHTML(sections[postType])}</h2>
          ${items.map((item) => this.renderResultItem(item, postType)).join("")}
        `;
      })
      .join("");

    this.searchResults.innerHTML = html;
  }

  renderResultItem(item, postType) {
    const author =
      item.author && item.authorURL
        ? ` by <a class="text-primary" href="${this.escapeAttr(item.authorURL)}">${this.escapeHTML(item.author)}</a>`
        : "";

    return `
      <div class="result-container my-5">
        <div class="row result-content">
          <div class="result-description justify-content-center d-flex flex-column col-12 col-md-6">
            <div class="result-title">
              <a class="text-danger" href="${this.escapeAttr(item.URL)}">${this.escapeHTML(item.title)}</a>${author}
            </div>
            <p>${this.escapeHTML(item.excerpt)}</p>
            <a class="text-primary" href="${this.escapeAttr(item.URL)}">Read more <i class="fa-solid fa-arrow-right"></i></a>
          </div>
          <div class="${postType === "events" ? "result-date" : "result-thumbnail"} col-12 col-md-6 d-flex justify-content-center">
            ${postType === "events" ? this.renderEventDate(item.date) : this.renderImage(item)}
          </div>
        </div>
      </div>
      <hr>
    `;
  }

  renderEventDate(rawDate) {
    const month = rawDate ? rawDate.slice(4, 6) : "TBA";
    const day = rawDate ? rawDate.slice(6, 8) : "";

    return `
      <div class="col-6 col-sm-3 d-flex align-items-center">
        <div class="event-date px-5 py-4 rounded-circle bg-warning">
          <h4 class="event-month text-white text-center">${this.escapeHTML(month)}</h4>
          ${day ? `<h4 class="event-date text-white text-center">${this.escapeHTML(day)}</h4>` : ""}
        </div>
      </div>
    `;
  }

  renderImage(item) {
    if (!item.thumbnail) {
      return '<div class="post-thumbnail__placeholder d-flex align-items-center justify-content-center text-muted">No image available</div>';
    }

    return `<img src="${this.escapeAttr(item.thumbnail)}" alt="${this.escapeAttr(item.title)}">`;
  }

  showSearchOverlay() {
    document.querySelector("header").insertAdjacentHTML(
      "afterend",
      `
      <div class="search-overlay overflow-auto position-fixed start-0 end-0 top-0 bottom-0 z-index-2 bg-white" role="dialog" aria-modal="true" aria-hidden="true" aria-label="Site search">
        <div class="container">
          <div class="row">
            <div class="search-box my-5 d-flex align-items-center gap-2 justify-content-center">
              <i class="fa-solid fa-magnifying-glass text-danger fs-3" aria-hidden="true"></i>
              <input type="text" class="search-input w-100 rounded d-flex p-2" placeholder="What are you searching for..." aria-label="Search keyword">
              <button type="button" class="close-search-icon bg-transparent border-0 text-danger" aria-label="Close search"><i class="fa fa-window-close fs-1" aria-hidden="true"></i></button>
            </div>
          </div>
          <div class="row">
            <div class="search-results"></div>
          </div>
        </div>
      </div>
    `,
    );
  }

  escapeHTML(value = "") {
    return String(value)
      .replace(/&/g, "&amp;")
      .replace(/</g, "&lt;")
      .replace(/>/g, "&gt;")
      .replace(/"/g, "&quot;")
      .replace(/'/g, "&#039;");
  }

  escapeAttr(value = "") {
    return this.escapeHTML(value);
  }
}

export default Search;
