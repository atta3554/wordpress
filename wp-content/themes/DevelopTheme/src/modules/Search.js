class Search {
    constructor() {
        this.showSearchOverlay()
        this.openSearchButton= document.querySelector('.search-icon a');
        this.closeSearchButton= document.querySelector('.close-search-icon');
        this.searchBox= document.querySelector('.search-overlay');
        this.searchInp= document.querySelector('.search-input')
        this.searchResults= document.querySelector('.search-results');
        this.isOverlayOpen= false;
        this.isSpinnerLoading= false;
        this.eventsHandler();
    }


    eventsHandler() {
        this.openSearchButton.addEventListener('click' , (event)=> this.openSearchBox(event))
        this.closeSearchButton.addEventListener('click' , ()=> this.closeSearchBox())
        this.searchInp.addEventListener('keypress', event=> this.getUserText(event))
        window.addEventListener('keyup', event=> {
            if(event.key=== 'Escape' && this.isOverlayOpen) this.closeSearchBox() 
        })
    }


    openSearchBox(event) {
        event.preventDefault();
        this.searchInp.value=''
        this.searchResults.innerHTML=''
        if(!this.isOverlayOpen) {
            this.searchBox.classList.add('active')
            document.body.classList.add('overflow-hidden');
            this.isOverlayOpen = true;
            setTimeout(() => {
                this.searchInp.focus();
            }, 301);
        }
    }


    closeSearchBox() {
        if(this.isOverlayOpen) {
            this.searchBox.classList.remove('active')
            document.body.classList.remove('overflow-hidden');
            this.isOverlayOpen = false;
        }
    }


    getUserText(event) {
        if(!this.isSpinnerLoading) {
            this.searchResults.innerHTML= '<div class="search-spinner"></div>'
            this.isSpinnerLoading = true;
        }
        clearTimeout(this.getText);
        this.getText= setTimeout(() => this.fetchData(event), 800);
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

        fetch(`${themeData.root_url}/wp-json/ataRoute/v1/search?keyword=${event.target.value}`)
            .then(res=> res.json())
            .then(data=> {
                this.searchResults.innerHTML= '';
                for (const postType in data) {
                    if(data[postType].length) {
                        this.searchResults.innerHTML+= `<h2 class='text-center'>From our ${postType}</h2>`
                        data[postType].forEach(single=> {
                            this.searchResults.innerHTML+= `
                                <div class="result-container my-5">
                                    <div class='row result-content'>
                                        <div class="result-description justify-content-center d-flex flex-column col-6">
                                            <div class="result-title">
                                                <a class='text-danger' href="${single.URL}">${single.title}</a> ${(single.author) ? `by ${single.author}` : ''}
                                            </div>
                                            ${single.excerpt}
                                            <a class='text-primary' href="${single.URL}">Read more<i class='fa-solid fa-arrow-right'></i></a>
                                        </div>
                                        <div class="${(postType === 'events') ? `result-date` : `result-thumbnail`} col-6 d-flex justify-content-center">
                                            ${(postType === 'events') ? `
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
                            `
                        })
                    } else {
                        this.searchResults.insertAdjacentHTML('afterbegin', `<h4 class='text-center'> nothing matches your search thourugh ${postType} ${(postType !== 'pages') ? 
                        ` <a class='text-primary' href='${themeData.root_url}/${(postType === 'posts') ? `blog` : postType}'>See All ${postType}<i class='fa-solid fa-arrow-right'></i></a>` : ``}</h2><hr>`)
                    }
                }
            })
            this.isSpinnerLoading= false;

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
        `)
    }
}

export default Search;