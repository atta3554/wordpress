class MyNotes {
  constructor() {

      if(document.querySelector('#notes-container')) {
          this.deleteNoteBtns = document.querySelectorAll('.delete-note');
          this.editNoteBtns = document.querySelectorAll('.edit-note');
          this.submitNote= document.querySelector('.submit-note')
          this.isEditing= false;
          this.event();
      }
  }




  event() {
      this.deleteNoteBtns.forEach(btn=> {
          btn.addEventListener('click', (event)=> this.deleteNote(event))
      })

      this.editNoteBtns.forEach(btn=> {
          btn.addEventListener('click', (event)=> this.editNote(event))
      })

      this.submitNote.addEventListener('click', event=> this.createNote(event))
  }




  deleteNote(event) {
      let noteBox;
      (event.target.innerHTML.includes('Delete')) ? noteBox = event.target.parentElement.parentElement.parentElement : noteBox = event.target.parentElement.parentElement.parentElement.parentElement

        fetch(`${themeData.root_url}/wp-json/wp/v2/note/${noteBox.getAttribute('data-id')}`, {
          method: 'DELETE',
          headers : {
              'content-type': 'application/json',
              'X-WP-Nonce': themeData.nonce
          }
      }
      )
          .then((res)=> {
              noteBox.classList.add('hide')
              setTimeout(() => {
                  document.querySelector('.delete-note__alert-container').classList.add('active')
              }, 100);
              setTimeout(() => {
                  document.querySelector('.delete-note__alert-bg').classList.add('active')
              }, 200);
              setTimeout(()=> {
                  document.querySelector('.delete-note__alert-bg').classList.remove('active')
              }, 1000)
              setTimeout(() => {
                  document.querySelector('.delete-note__alert-container').classList.remove('active')
              }, 1500);
          })

  }




  editNote(event) {
      let noteBox;
      if(this.isEditing && (event.target.innerHTML.includes('Edit') || event.target.parentElement.innerHTML.includes('Edit'))) alert('please finish your previous note editing first'); 
      else {
        ([...event.target.classList].includes('fa-pencil') || [...event.target.classList].includes('fa-check')) ? noteBox = event.target.parentElement.parentElement.parentElement.parentElement
        : noteBox = event.target.parentElement.parentElement.parentElement
        
        if(!this.isEditing) {
            this.makeNoteEditable(noteBox)
        } else {
            this.updateNote(noteBox)
        }
      }
  }




  makeNoteEditable(box) {
    let cancelNote = box.querySelector('.cancel-note')
    let currentNoteTitle = box.querySelector('.note-title')
    let currentNoteBody = box.querySelector('.note-body')

    cancelNote.classList.add('active')
    cancelNote.addEventListener('click',()=> this.cancelEdit(box))
  
    box.querySelector('.edit-note').innerHTML= `<i class='fa fa-check me-2' aria-hidden='true'></i>Save`

    currentNoteTitle.removeAttribute('readonly')
    currentNoteTitle.classList.add('active')
    
    currentNoteBody.removeAttribute('readonly')
    currentNoteBody.classList.add('active')

    this.isEditing= true;
  }




  cancelEdit(box){
      this.makeNoteReadbaleOnly(box)
      let prevTitle = box.querySelector('.note-title').value 
      let prevBody = box.querySelector('.note-body').value 

      box.querySelector('.note-title').value= prevTitle
      box.querySelector('.note-body').value= prevBody
  }




  makeNoteReadbaleOnly(box) {
      box.querySelector('.cancel-note').classList.remove('active')
      box.querySelector('.edit-note').innerHTML= `<i class='fa fa-pencil me-2' aria-hidden='true'></i>Edit`

      box.querySelector('.note-title').setAttribute('readonly', true)
      box.querySelector('.note-title').classList.remove('active')
      
      box.querySelector('.note-body').setAttribute('readonly', true)
      box.querySelector('.note-body').classList.remove('active')
      
      this.isEditing= false;
  }




  updateNote(box) { 
      fetch(`${themeData.root_url}/wp-json/wp/v2/note/${box.getAttribute('data-id')}`, {
          method: 'POST',
          headers : {
              'content-type': 'application/json',
              'X-WP-Nonce': themeData.nonce
          },
          body : JSON.stringify({
              'title': box.querySelector('.note-title').value,
              'content': box.querySelector('.note-body').value
          })
      }
      )
          .then((res)=> res.json())
          .then(data=> this.makeNoteReadbaleOnly(box))
  }




  createNote(event){

    let currentTitle= event.target.previousElementSibling.previousElementSibling;
    let currentBody= event.target.previousElementSibling;
    
    fetch(`${themeData.root_url}/wp-json/wp/v2/note`, {
      method: 'POST',
      headers : {
        'content-type': 'application/json',
        'X-WP-Nonce': themeData.nonce
      },
      body : JSON.stringify({
        'title': currentTitle.value,
        'content': currentBody.value,
        'status': 'private'
      })
    })
      .then(res=> res.json())
      .then(data=> {
        if(data.error && data.error === 'limit note count! delete some notes first') alert('you have reached your limit notes count! please delete one first in order to create another')
        else this.makeNoteTemplate(event, currentTitle, currentBody, data.id)
      })
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
      `)

      document.querySelector('.note-box').querySelector('.edit-note').addEventListener('click', (event)=> this.editNote(event))
      document.querySelector('.note-box').querySelector('.delete-note').addEventListener('click', (event)=> this.deleteNote(event))

      title.value= ''
      body.value= ''
  }

}

export default MyNotes;