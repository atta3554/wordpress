/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./src/modules/Search.js":
/*!*******************************!*\
  !*** ./src/modules/Search.js ***!
  \*******************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
class Search {
  constructor() {
    this.showSearchOverlay();
    this.openSearchButton = document.querySelector('.search-icon a');
    this.closeSearchButton = document.querySelector('.close-search-icon');
    this.searchBox = document.querySelector('.search-overlay');
    this.searchInp = document.querySelector('.search-input');
    this.searchResults = document.querySelector('.search-results');
    this.isOverlayOpen = false;
    this.isSpinnerLoading = false;
    this.eventsHandler();
  }
  eventsHandler() {
    this.openSearchButton.addEventListener('click', event => this.openSearchBox(event));
    this.closeSearchButton.addEventListener('click', () => this.closeSearchBox());
    this.searchInp.addEventListener('keypress', event => this.getUserText(event));
    window.addEventListener('keyup', event => {
      if (event.key === 'Escape' && this.isOverlayOpen) this.closeSearchBox();
    });
  }
  openSearchBox(event) {
    event.preventDefault();
    this.searchInp.value = '';
    this.searchResults.innerHTML = '';
    if (!this.isOverlayOpen) {
      this.searchBox.classList.add('active');
      document.body.classList.add('overflow-hidden');
      this.isOverlayOpen = true;
      setTimeout(() => {
        this.searchInp.focus();
      }, 301);
    }
  }
  closeSearchBox() {
    if (this.isOverlayOpen) {
      this.searchBox.classList.remove('active');
      document.body.classList.remove('overflow-hidden');
      this.isOverlayOpen = false;
    }
  }
  getUserText(event) {
    if (!this.isSpinnerLoading) {
      this.searchResults.innerHTML = '<div class="search-spinner"></div>';
      this.isSpinnerLoading = true;
    }
    clearTimeout(this.getText);
    this.getText = setTimeout(() => this.fetchData(event), 800);
  }
  async fetchData(event) {
    /************************************************************ First Method - With Multiple Default WP APIs And Categorised By Index ************************************************************/

    // let postsUrl = `${themeData.root_url}/wp-json/wp/V2/posts?search=${event.target.value}`
    // let pagesUrl = `${themeData.root_url}/wp-json/wp/V2/pages?search=${event.target.value}`
    // let seminarsUrl = `${themeData.root_url}/wp-json/wp/V2/seminar?search=${event.target.value}`
    // let eventsUrl = `${themeData.root_url}/wp-json/wp/V2/event?search=${event.target.value}`
    // let professorsUrl = `${themeData.root_url}/wp-json/wp/V2/professor?search=${event.target.value}`
    // let response = await Promise.all([fetch(postsUrl), fetch(pagesUrl), fetch(seminarsUrl), fetch(eventsUrl), fetch(professorsUrl)])

    // this.searchResults.innerHTML = ''
    // response.forEach((event, index)=> event.json().then(data=> {
    // let resultPosts = data.map(post=> `
    // <div class="result-container my-5">
    //     <div class='row result-content'>
    //         <div class="result-description justify-content-center d-flex flex-column col-6">
    //             <div class="result-title">
    //                 <a class='text-danger' href="${post.link}">${post.title.rendered}</a> ${(post.postAuthor) ? `by ${post.postAuthor}` : ''}
    //             </div>
    //             ${post.excerpt.rendered}
    //             <a class='text-primary' href="${post.link}">Read more<i class='fa-solid fa-arrow-right'></i></a>
    //         </div>
    //         <div class="result-thumbnail col-6 d-flex justify-content-center">
    //             <img src='${post.uagb_featured_image_src.medium[0]}'alt='thumbnail'>
    //         </div>
    //     </div> 
    // </div>
    // <hr>
    // `)

    // if(resultPosts.length) {
    //     this.searchResults.innerHTML += `<h2 class='text-center'>from our ${(index===0) ? 'posts' : (index===1) ? 'pages' : (index===2) ? 'seminars' : (index===3) ? 'events' : 'professors'} </h2> 
    //     ${resultPosts.join('')}`
    // } else {
    //     this.searchResults.insertAdjacentHTML('afterbegin', `<p class="text-center">nothing matches your request in ${(index===0) ? 'posts' : (index===1) ? 'pages' : (index===2) ? 'seminars' : (index===3) ? 'events' : 'professors'}</p>`)
    // }
    // }))

    // this.isSpinnerLoading= false;

    /************************************************************ First Method - With Multiple Default WP APIs And Categorised By Index ************************************************************/

    /************************************************************ Second Method - With Single Custom WP API And Categorised According To Title With High Time Complexity (At Least  O(n)) ************************************************************/

    fetch(`${themeData.root_url}/wp-json/ataRoute/v1/search?keyword=${event.target.value}`).then(res => res.json()).then(data => {
      this.searchResults.innerHTML = '';
      for (const postType in data) {
        if (data[postType].length) {
          this.searchResults.innerHTML += `<h2 class='text-center'>From our ${postType}</h2>`;
          data[postType].forEach(single => {
            this.searchResults.innerHTML += `
                                <div class="result-container my-5">
                                    <div class='row result-content'>
                                        <div class="result-description justify-content-center d-flex flex-column col-6">
                                            <div class="result-title">
                                                <a class='text-danger' href="${single.URL}">${single.title}</a> ${single.author ? `by ${single.author}` : ''}
                                            </div>
                                            ${single.excerpt}
                                            <a class='text-primary' href="${single.URL}">Read more<i class='fa-solid fa-arrow-right'></i></a>
                                        </div>
                                        <div class="${postType === 'events' ? `result-date` : `result-thumbnail`} col-6 d-flex justify-content-center">
                                            ${postType === 'events' ? `
                                            <div class="col-3 d-flex align-items-center">
                                                <div class="event-date px-5 py-4 rounded-circle bg-warning">
                                                    <h4 class="event-month text-white text-center">${single.date.slice(6, 8)}</h4>
                                                    <h4 class="event-date text-white text-center">${single.date.slice(4, 6)}</h4>
                                                </div>
                                            </div>
                                            ` : `<img src='${single.thumbnail}'alt='thumbnail'>`}
                                        </div>
                                    </div> 
                                </div>
                                <hr>
                            `;
          });
        } else {
          this.searchResults.insertAdjacentHTML('afterbegin', `<h4 class='text-center'> nothing matches your search thourugh ${postType} ${postType !== 'pages' ? ` <a class='text-primary' href='${themeData.root_url}/${postType === 'posts' ? `blog` : postType}'>See All ${postType}<i class='fa-solid fa-arrow-right'></i></a>` : ``}</h2><hr>`);
        }
      }
    });
    this.isSpinnerLoading = false;

    /************************************************************ Second Method - With Single Custom WP API And Categorised According To Title With High Time Complexity (At Least  O(n)) ************************************************************/

    /************************************************************ Second Method - With Single Custom WP API And Categorised According To Title With Less Time Complexity (About O(Log(n)) ) ************************************************************/

    // fetch(`http://localhost/DevelopTheme/wordpress/wp-json/ataRoute/v1/search?keyword=${event.target.value}`)
    // .then(res=> res.json())
    // .then(data=> {
    //     this.searchResults.innerHTML= `
    //         <div class='container'>
    //             <div class='row'>
    //                 <div class='row posts-container'>
    //                     <h2 class='text-center'>From Our Posts</h2>
    //                     ${(data.posts.length) ? data.posts.map(post=> {
    //                         return `
    //                             <div class='row single-post__container my-5'>
    //                                 <div class='col-6 single-post__description'>
    //                                     <h4><a href='${post.URL}' class='text-danger'>${post.title}</a></h4>
    //                                     <p>${post.excerpt}</p>
    //                                     <span><a href='${post.URL}' class='text-primary'>Read More <i class='fa-solid fa-arrow-right'></i></a></span>
    //                                 </div>
    //                                 <div class='col-6 d-flex justify-content-center single-post__thumbnail'>
    //                                     <img src='${post.thumbnail}'>
    //                                 </div>
    //                             </div>
    //                             <hr>
    //                         `
    //                     }).join('') : "<h4 class='text-center text-danger py-4'>Nothing Matches Your Search Thourough Our Posts</h4><hr>"}
    //                 </div>

    //                 <div class='row professors-container'>
    //                     <h2 class='text-center'>From Our Professors</h2>
    //                     ${(data.professors.length) ? data.professors.map(professor=> {
    //                         return `
    //                             <div class='row single-professor__container my-5'>
    //                                 <div class='col-6 single-professor__description'>
    //                                     <h4><a href='${professor.URL}' class='text-danger'>${professor.title}</a></h4>
    //                                     <p>${professor.excerpt}</p>
    //                                     <span><a href='${professor.URL}' class='text-primary'>Read More <i class='fa-solid fa-arrow-right'></i></a></span>
    //                                 </div>
    //                                 <div class='col-6 d-flex justify-content-center single-professor__thumbnail'>
    //                                     <img src='${professor.thumbnail}'>
    //                                 </div>
    //                             </div>
    //                             <hr>
    //                         `
    //                     }).join('') : "<h4 class='text-center text-danger py-4'>Nothing Matches Your Search Thourough Our professors</h4><hr>"}
    //                 </div>

    //                 <div class='row'>
    //                     <div class='col-4 events-container'>
    //                         <h4 class='text-center'>From Our Events</h4>
    //                         ${(data.events.length) ? data.events.map(event=>(
    //                             `<div class='row single-event__container'>
    //                                 <div class='row single-event__title'>${event.title}</div>
    //                                 <div class='row single-event__excerpt'>${event.excerpt}</div>
    //                                 <div class='row'>
    //                                     <span><a href='${event.URL}' class='text-primary'>Read More <i class='fa-solid fa-arrow-right'></i></a></span>
    //                                 </div>
    //                             </div>
    //                             <hr>`
    //                         )).join('') : "<h4 class='text-center text-danger py-4'>Nothing Matches Your Search Thourough Our Events</h4><hr>"}
    //                     </div>

    //                     <div class='col-4 pages-container'>
    //                         <h4 class='text-center'>From Our Pages</h4>
    //                         ${(data.pages.length) ? data.pages.map(page=>(
    //                             `<div class='single-page__container'>
    //                                 <div class='row single-page__title'>${page.title}</div>
    //                                 <div class='row single-page__excerpt'>${page.excerpt}</div>
    //                                 <div class='row'>
    //                                     <span><a href='${page.URL}' class='text-primary'>Read More <i class='fa-solid fa-arrow-right'></i></a></span>
    //                                 </div>
    //                             </div>
    //                             <hr>`
    //                         )).join('') : "<h4 class='text-center text-danger py-4'>Nothing Matches Your Search Thourough Our Pages</h4><hr>"}
    //                     </div>

    //                     <div class='col-4 seminars container'>
    //                         <h4 class='text-center'>From Our Seminars</h4>
    //                         ${(data.seminars.length) ? data.seminars.map(seminar=>(
    //                             `<div class='single-seminar__container'>
    //                                 <div class='row single-seminar__title'>${seminar.title}</div>
    //                                 <div class='row single-seminar__excerpt'>${seminar.excerpt}</div>
    //                                 <div class='row'>
    //                                     <span><a href='${seminar.URL}' class='text-primary'>Read More <i class='fa-solid fa-arrow-right'></i></a></span>
    //                                 </div>
    //                             </div>
    //                             <hr>`
    //                         )).join('') : "<h4 class='text-center text-danger py-4'>Nothing Matches Your Search Thourough Our Seminars</h4><hr>"}
    //                     </div>

    //                 </div>
    //             </div>
    //         </div>
    //     `;            
    // })

    // this.isSpinnerLoading= false;

    /************************************************************ Second Method - With Single Custom WP API And Categorised According To Title With Less Time Complexity (About O(Log(n)) ) ************************************************************/
  }
  showSearchOverlay() {
    document.querySelector('header').insertAdjacentHTML('afterend', `
            <div class="search-overlay overflow-auto position-fixed start-0 end-0 top-0 bottom-0 z-index-2 bg-white">
                <div class="container">

                    <div class="row">
                        <div class="search-box my-5 d-flex align-items-center gap-2 justify-content-center">
                            <i class="fa-solid fa-magnifying-glass text-danger fs-3"></i>
                            <input type="text" class="search-input w-100 rounded d-flex p-2" placeholder='what are you searching for...'>
                            <i class="fa fa-window-close fs-1 text-danger close-search-icon"></i>
                        </div>
                    </div>

                    <div class="row">
                        <div class="search-results"></div>
                    </div>

                </div>
            </div>
        `);
  }
}
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (Search);

/***/ }),

/***/ "./src/modules/myNotes.js":
/*!********************************!*\
  !*** ./src/modules/myNotes.js ***!
  \********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
class MyNotes {
  constructor() {
    if (document.querySelector('#notes-container')) {
      this.deleteNoteBtns = document.querySelectorAll('.delete-note');
      this.editNoteBtns = document.querySelectorAll('.edit-note');
      this.submitNote = document.querySelector('.submit-note');
      this.isEditing = false;
      this.event();
    }
  }
  event() {
    this.deleteNoteBtns.forEach(btn => {
      btn.addEventListener('click', event => this.deleteNote(event));
    });
    this.editNoteBtns.forEach(btn => {
      btn.addEventListener('click', event => this.editNote(event));
    });
    this.submitNote.addEventListener('click', event => this.createNote(event));
  }
  deleteNote(event) {
    let noteBox;
    event.target.innerHTML.includes('Delete') ? noteBox = event.target.parentElement.parentElement.parentElement : noteBox = event.target.parentElement.parentElement.parentElement.parentElement;
    fetch(`${themeData.root_url}/wp-json/wp/v2/note/${noteBox.getAttribute('data-id')}`, {
      method: 'DELETE',
      headers: {
        'content-type': 'application/json',
        'X-WP-Nonce': themeData.nonce
      }
    }).then(res => {
      noteBox.classList.add('hide');
      setTimeout(() => {
        document.querySelector('.delete-note__alert-container').classList.add('active');
      }, 100);
      setTimeout(() => {
        document.querySelector('.delete-note__alert-bg').classList.add('active');
      }, 200);
      setTimeout(() => {
        document.querySelector('.delete-note__alert-bg').classList.remove('active');
      }, 1000);
      setTimeout(() => {
        document.querySelector('.delete-note__alert-container').classList.remove('active');
      }, 1500);
    });
  }
  editNote(event) {
    let noteBox;
    if (this.isEditing && (event.target.innerHTML.includes('Edit') || event.target.parentElement.innerHTML.includes('Edit'))) alert('please finish your previous note editing first');else {
      [...event.target.classList].includes('fa-pencil') || [...event.target.classList].includes('fa-check') ? noteBox = event.target.parentElement.parentElement.parentElement.parentElement : noteBox = event.target.parentElement.parentElement.parentElement;
      if (!this.isEditing) {
        this.makeNoteEditable(noteBox);
      } else {
        this.updateNote(noteBox);
      }
    }
  }
  makeNoteEditable(box) {
    let cancelNote = box.querySelector('.cancel-note');
    let currentNoteTitle = box.querySelector('.note-title');
    let currentNoteBody = box.querySelector('.note-body');
    cancelNote.classList.add('active');
    cancelNote.addEventListener('click', () => this.cancelEdit(box));
    box.querySelector('.edit-note').innerHTML = `<i class='fa fa-check me-2' aria-hidden='true'></i>Save`;
    currentNoteTitle.removeAttribute('readonly');
    currentNoteTitle.classList.add('active');
    currentNoteBody.removeAttribute('readonly');
    currentNoteBody.classList.add('active');
    this.isEditing = true;
  }
  cancelEdit(box) {
    this.makeNoteReadbaleOnly(box);
    let prevTitle = box.querySelector('.note-title').value;
    let prevBody = box.querySelector('.note-body').value;
    box.querySelector('.note-title').value = prevTitle;
    box.querySelector('.note-body').value = prevBody;
  }
  makeNoteReadbaleOnly(box) {
    box.querySelector('.cancel-note').classList.remove('active');
    box.querySelector('.edit-note').innerHTML = `<i class='fa fa-pencil me-2' aria-hidden='true'></i>Edit`;
    box.querySelector('.note-title').setAttribute('readonly', true);
    box.querySelector('.note-title').classList.remove('active');
    box.querySelector('.note-body').setAttribute('readonly', true);
    box.querySelector('.note-body').classList.remove('active');
    this.isEditing = false;
  }
  updateNote(box) {
    fetch(`${themeData.root_url}/wp-json/wp/v2/note/${box.getAttribute('data-id')}`, {
      method: 'POST',
      headers: {
        'content-type': 'application/json',
        'X-WP-Nonce': themeData.nonce
      },
      body: JSON.stringify({
        'title': box.querySelector('.note-title').value,
        'content': box.querySelector('.note-body').value
      })
    }).then(res => res.json()).then(data => this.makeNoteReadbaleOnly(box));
  }
  createNote(event) {
    let currentTitle = event.target.previousElementSibling.previousElementSibling;
    let currentBody = event.target.previousElementSibling;
    fetch(`${themeData.root_url}/wp-json/wp/v2/note`, {
      method: 'POST',
      headers: {
        'content-type': 'application/json',
        'X-WP-Nonce': themeData.nonce
      },
      body: JSON.stringify({
        'title': currentTitle.value,
        'content': currentBody.value,
        'status': 'private'
      })
    }).then(res => res.json()).then(data => {
      if (data.error && data.error === 'limit note count! delete some notes first') alert('you have reached your limit notes count! please delete one first in order to create another');else this.makeNoteTemplate(event, currentTitle, currentBody, data.id);
    });
  }
  makeNoteTemplate(event, title, body, id) {
    event.target.parentElement.parentElement.nextElementSibling.insertAdjacentHTML('afterbegin', `
      <div class="note-box border rounded mx-5 py-4 my-5 col-5 d-flex overflow-hidden flex-column" data-id='${id}'>
          <div class='d-flex px-3 justify-content-between align-items-center'>
              <input readonly class='note-title px-3 py-2 my-3' type="text" value='${title.value}'>
              <div class='d-flex'>
                  <span role="button" class="edit-note border rounded px-2 mx-2"><i class='fa fa-pencil me-2' aria-hidden="true"></i>Edit</span>
                  <span role="button" class="delete-note border rounded px-2 border-danger text-danger"><i class='fa fa-trash-o me-2' aria-hidden="true"></i>Delete</span>
              </div>
          </div>
          <textarea readonly class='note-body p-3 w-100 overflow-auto'>${body.value}</textarea>
          <div class="row">
            <div class="col-3">
                <span class='cancel-note mx-auto my-2 bg-primary text-white text-center rounded py-2' role='button'>
                    <i class='fa fa-close me-2' aria-hidden='true'></i>Cancel
                </span>
            </div>
            <div class="col-9">
                <span class="error-message">your notes count has reached to Limit; please delete a note</span>
            </div>
        </div>
      </div>
      `);
    document.querySelector('.note-box').querySelector('.edit-note').addEventListener('click', event => this.editNote(event));
    document.querySelector('.note-box').querySelector('.delete-note').addEventListener('click', event => this.deleteNote(event));
    title.value = '';
    body.value = '';
  }
}
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (MyNotes);

/***/ }),

/***/ "./src/modules/professorLike.js":
/*!**************************************!*\
  !*** ./src/modules/professorLike.js ***!
  \**************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
class Like {
  // events will call here
  constructor() {
    if (document.querySelector('.professor-likes')) {
      this.likeBtn = document.querySelector('.professor-likes .like-area');
      this.likesCount = document.querySelector('.professor-likes .likes-count');
      this.likeicon;
      this.event();
    }
  }

  // Events will add here
  event() {
    this.likeBtn.addEventListener('click', event => this.checkStatus(event));
  }

  // events will Declare Here
  checkStatus(event) {
    if ([...event.target.classList].includes('like-area')) {
      this.likeicon = event.target.children[0].children[0];
    } else if ([...event.target.classList].includes('like-btn')) {
      this.likeicon = event.target.children[0];
    } else if ([...event.target.classList].includes('likes-count')) {
      this.likeicon = event.target.previousElementSibling.children[0];
    } else {
      this.likeicon = event.target;
    }
    let isLikes = this.likeBtn.parentElement.getAttribute('data-exist');
    if (isLikes == 'no') {
      this.likeProfessor();
    } else {
      this.disLikeProfessor();
    }
  }
  likeProfessor() {
    fetch(`${themeData.root_url}/wp-json/ataRoute/v1/like`, {
      method: 'POST',
      headers: {
        'content-type': 'application/json',
        'X-WP-Nonce': themeData.nonce
      },
      body: JSON.stringify({
        'professorId': this.likeicon.parentElement.parentElement.parentElement.getAttribute('data-professor')
      })
    }).then(res => res.json()).then(data => {
      if (data !== 'only logged in users can like professors' && data !== 'invalid professor id') {
        +this.likeicon.parentElement.nextElementSibling.innerHTML++;
        this.likeicon.parentElement.parentElement.parentElement.setAttribute('data-exist', 'yes');
        this.likeicon.parentElement.parentElement.parentElement.setAttribute('data-like', data);
        this.likeicon.classList.remove('fa-regular');
        this.likeicon.classList.add('fa-solid');
      } else if (data === 'invalid professor id') {
        alert('you are trying to manipulate my website! I will kill you😈');
      } else {
        alert('you dont have permission to Like professors! only logged in users can do this');
      }
    }).catch(err => console.log(err));
  }
  disLikeProfessor() {
    fetch(`${themeData.root_url}/wp-json/ataRoute/v1/like`, {
      method: 'DELETE',
      headers: {
        'content-type': 'application/json',
        'X-WP-Nonce': themeData.nonce
      },
      body: JSON.stringify({
        'like': this.likeicon.parentElement.parentElement.parentElement.getAttribute('data-like')
      })
    }).then(res => res.json()).then(data => {
      console.log(data);
      +this.likeicon.parentElement.nextElementSibling.innerHTML--;
      this.likeicon.parentElement.parentElement.parentElement.setAttribute('data-exist', 'no');
      this.likeicon.parentElement.parentElement.parentElement.removeAttribute('data-like');
      this.likeicon.classList.remove('fa-solid');
      this.likeicon.classList.add('fa-regular');
    }).catch(err => console.log(err));
  }
}
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (Like);

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
(() => {
/*!**********************!*\
  !*** ./src/index.js ***!
  \**********************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _modules_Search__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./modules/Search */ "./src/modules/Search.js");
/* harmony import */ var _modules_myNotes__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./modules/myNotes */ "./src/modules/myNotes.js");
/* harmony import */ var _modules_professorLike__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./modules/professorLike */ "./src/modules/professorLike.js");
// Impor Modules




// create instance
const search = new _modules_Search__WEBPACK_IMPORTED_MODULE_0__["default"]();
const myNtes = new _modules_myNotes__WEBPACK_IMPORTED_MODULE_1__["default"]();
const LikeProf = new _modules_professorLike__WEBPACK_IMPORTED_MODULE_2__["default"]();
})();

/******/ })()
;
//# sourceMappingURL=index.js.map