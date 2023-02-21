import '../css/app.scss'

import 'bootstrap/dist/js/bootstrap'
handleCommentForm()

function handleCommentForm(){
    const commentForm = document.querySelector('form.comment-form');
    if (commentForm === null) {
        return;
    }
    commentForm.addEventListener('submit',async(e)=>{
        e.preventDefault();

        const response = await fetch('ajax/comments',{
            method:'POST',
            body:new FormData(e.target)
        });

        if(!response.ok){
            return;
        }

        const json = await response.json();

        if ("COMMENT_ADDED_SUCCESSFULLY" === json.code) {
            const commentList = document.querySelector('.comment-list');
            const commentCount= document.querySelector('#comment-count');
            const commentContent = document.querySelector('#comment_content');

            commentList.insertAdjacentHTML('afterbegin',json.message);
            //commentList.lastElementChild.scrollIntoView();

            commentCount.innerText = json.numberOfComments;
            commentContent.value = ''
        }
    });
}