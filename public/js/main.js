const members=document.getElementById('members');

if (members){
    members.addEventListener('click', e=> {
        if (e.target.className === 'badge badge-pill badge-danger delete-article'){

            if(confirm('Are you sure?')){
                const id = e.target.getAttribute('data-id');
                return fetch('/member/delete/'+id,{method:'DELETE'}).then(res=>window.location.reload());
            }
        }
    });
}