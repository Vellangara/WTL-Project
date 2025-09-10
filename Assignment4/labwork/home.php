<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
body {
    font-family: Arial, sans-serif;
    background: #f9f9f9;
    padding: 20px;
}

form {
    background: #fff;
    padding: 15px;
    margin: 15px auto;
    border-radius: 6px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    max-width: 400px;
}

form h3, form h4 {
    margin-top: 0;
    color: #007BFF;
}

form label {
    display: block;
    margin: 8px 0 4px;
}

form input {
    width: 100%;
    padding: 6px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

form button {
    background: #FF0000;
    color: white;
    border: none;
    padding: 8px 14px;
    border-radius: 4px;
    cursor: pointer;
}
form button:hover {
    background: #b30000;
}

#resultdiv {
    text-align: center;
    font-weight: bold;
    margin: 10px 0;
}

table {
    width: 90%;
    margin: 20px auto;
    border-collapse: collapse;
    background: #fff;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}
table th, table td {
    padding: 10px;
    border: 1px solid #ddd;
}
table thead {
    background: #007BFF;
    color: #fff;
}
    </style>
</head>
<body>
    <form>
        Student Name:<input type="text" id="id1">
        Enter marks: <input type="text" id="id2">
        <button type="button" id="btn">SUBMIT</button>
        <button type="button" id="btn1">GET DATA</button>
    </form>

    <form id="deleteForm">
        <label>Student ID to Delete: <input type="text" name="id"></label>
        <button type="button" id="deleteBtn">Delete</button>
    </form>
    <form id="checkUpdateForm">
        <label>Student ID to Check: <input type="text" name="id"></label>
        <button type="button" id="checkUpdateBtn">Check for Update</button>
    </form>
    <form id="updateForm" style="display:none;">
        <label>ID: <input type="text" name="id" readonly></label>
        <label>Name: <input type="text" name="name"></label>
        <label>Marks: <input type="text" name="marks"></label>
        <button type="button" id="updateBtn">Update</button>
    </form>
    <div id="resultdiv"></div>
    <br>
    <!-- Table to show fetched data -->
    <table border="1" id="table">
        <thead>
            <tr>
                <th>Student Name</th>
                <th>Marks</th>
            </tr>
        </thead>
        <tbody id="tableBody">
        </tbody>
    </table>

    <script>
    async function senddata() {
        let name = document.getElementById("id1").value;
        let marks = document.getElementById("id2").value;
        let data = new FormData();
        data.append("sname", name);
        data.append("smarks", marks);

        await fetch("http://localhost/TEST/test.php", {
            method: "POST",
            body: data
        });
    }

    async function getdata() {
        let res = await fetch("http://localhost/TEST/getdata.php");
        let result = await res.json(); // expecting JSON from PHP

        let tableBody = document.getElementById("tableBody");
        tableBody.innerHTML = ""; // clear previous rows

        result.forEach(item => {
            let row = document.createElement("tr");

            let cell1 = document.createElement("td");
            cell1.textContent = item.name;
            row.appendChild(cell1);

            let cell2 = document.createElement("td");
            cell2.textContent = item.marks;
            row.appendChild(cell2);

            tableBody.appendChild(row);
        });
    }

    document.getElementById("btn").addEventListener("click", senddata);
    document.getElementById("btn1").addEventListener("click", getdata);

    document.getElementById("deleteBtn").addEventListener("click", async ()=>{
        let form = document.getElementById("deleteForm");
        let data = new FormData(form);
        let res = await fetch("bt3delete.php", {method:"POST", body:data});
        document.getElementById("resultdiv").textContent = await res.text();
        form.reset();
    });

    document.getElementById("checkUpdateBtn").addEventListener("click", async ()=>{
    let form = document.getElementById("checkUpdateForm");
    let data = new FormData(form);
    let res = await fetch("edit.php", {method:"POST", body:data});
    let student = await res.json();

    if(student.exists){
        document.getElementById("updateForm").style.display="block";
        document.querySelector("#updateForm input[name=id]").value = student.id;
        document.querySelector("#updateForm input[name=name]").value = student.name;
        document.querySelector("#updateForm input[name=marks]").value = student.marks;
    } else {
        document.getElementById("resultdiv").textContent = "ID not found!";
    }
});

document.getElementById("updateBtn").addEventListener("click", async ()=>{
    let form = document.getElementById("updateForm");
    let data = new FormData(form);
    let res = await fetch("edit.php", {method:"POST", body:data});
    let result = await res.json();
    document.getElementById("resultdiv").textContent = result.message;
    form.reset();
    document.getElementById("updateForm").style.display="none";
});
    
    </script>
</body>
</html>
