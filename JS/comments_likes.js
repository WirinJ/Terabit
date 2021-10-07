function doComment() {
    const val = document.getElementById("comment_message").value;
    const date = document.getElementById("comment_date").value;
    const user = document.getElementById("comment_user").value;
    const postId = document.getElementById("comment_id").value;
    if (val !== "") {
        fetch('fncomments.php', {
            method: 'post',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `uid=${user}&post_id=${postId}&date=${date}&commenst=${val}&commentsubmit=`
        })
        .then((response) => response.text())
        location.reload();
    }
}

/* 

    De code hieronder werkt maar de comment section wordt buggy.

    function refreshComments() {
        const postId = document.getElementById("comment_id").value;
        let section = document.querySelector("#commentSection");
        section.innerHTML = "";
        fetch(`http://localhost/Eindproject-Jaar--f6c54c88-bb8d26aa/fncomments.php?id=${postId}`, {
            method: 'post',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'refresh'
        })
        .then((response) => response.text())
        .then((data) => {
            section.innerHTML = data;
            console.log(data);
        }); 
    }

*/