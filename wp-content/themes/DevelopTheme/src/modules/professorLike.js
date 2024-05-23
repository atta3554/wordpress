class Like{


    // events will call here
    constructor() {
        if(document.querySelector('.professor-likes')){
            this.likeBtn = document.querySelector('.professor-likes .like-area')
            this.likesCount = document.querySelector('.professor-likes .likes-count')
            this.likeicon;
            this.event()
        }
    }

    


    // Events will add here
    event(){
        this.likeBtn.addEventListener('click', event=> this.checkStatus(event))
    }




    // events will Declare Here
    checkStatus(event) {
        
        if ([...event.target.classList].includes('like-area'))  {
            this.likeicon= event.target.children[0].children[0]
        }
        else if([...event.target.classList].includes('like-btn')) {
            this.likeicon= event.target.children[0]
        }
        else if([...event.target.classList].includes('likes-count')) {
            this.likeicon= event.target.previousElementSibling.children[0]
        }
        else {
            this.likeicon= event.target
        }

        let isLikes = this.likeBtn.parentElement.getAttribute('data-exist')

        if(isLikes == 'no'){
            this.likeProfessor()
        } else {
            this.disLikeProfessor()
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
                'professorId': this.likeicon.parentElement.parentElement.parentElement.getAttribute('data-professor')})
        })
        .then(res=> res.json())
        .then(data=> {
            if(data !== 'only logged in users can like professors' && data !== 'invalid professor id') {
                +this.likeicon.parentElement.nextElementSibling.innerHTML++;
                this.likeicon.parentElement.parentElement.parentElement.setAttribute('data-exist', 'yes')
                this.likeicon.parentElement.parentElement.parentElement.setAttribute('data-like', data)
                this.likeicon.classList.remove('fa-regular')
                this.likeicon.classList.add('fa-solid')
            } else if(data === 'invalid professor id') {
                alert('you are trying to manipulate my website! I will kill you😈')
            } else {
                alert('you dont have permission to Like professors! only logged in users can do this')
            }
        })
        .catch(err=> console.log(err))
    }



    disLikeProfessor() {
        fetch(`${themeData.root_url}/wp-json/ataRoute/v1/like`, {
            method: 'DELETE',
            headers: {
                'content-type': 'application/json',
                'X-WP-Nonce': themeData.nonce
            },
            body: JSON.stringify({'like': this.likeicon.parentElement.parentElement.parentElement.getAttribute('data-like'),})
        })
        .then(res=> res.json())
        .then(data=> {
            console.log(data);
            +this.likeicon.parentElement.nextElementSibling.innerHTML--;
            this.likeicon.parentElement.parentElement.parentElement.setAttribute('data-exist', 'no')
            this.likeicon.parentElement.parentElement.parentElement.removeAttribute('data-like')
            this.likeicon.classList.remove('fa-solid')
            this.likeicon.classList.add('   fa-regular')
        })
        .catch(err=> console.log(err))
    }
}

export default Like;