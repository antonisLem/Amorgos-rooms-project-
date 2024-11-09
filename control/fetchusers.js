fetch("users.json")
.then(function(response){
    return response.json();
})
.then(function(pageusers){
    let placeholder = document.querySelector("#users-output");
    let output = "";
    for(let pageuser of pageusers){
        output +=` 
        <tr>
            <td>${pageuser.name}</td>
            <td>${pageuser.surname}</td>
            <td>${pageuser.cname}</td>
            <td>${pageuser.phone}</td>
            <td>${pageuser.phone2}</td>
            <td>${pageuser.Email}</td>
            <td>${pageuser.username}</td>
            <td>${pageuser.password}</td>
            <td>${pageuser.password2}</td>
            <td>${pageuser.id}</td>
            <td><a href='delete_user.php?id=${pageuser.id}' id='btn' class="btn">Delete</a></td>  
        </tr>
        `;
    }

    placeholder.innerHTML = output;
})

