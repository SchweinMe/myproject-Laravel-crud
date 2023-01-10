<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Product</title>

    <style>
        table, th, td {
          border:1px solid black;
        }
        .container {
            display: flex;
            /* border: 1px solid blue; */
            /* align-items: center; */
        }
        .table {
            width: 90%;
            margin-left: 2rem;
            /* border: 1px solid red; */
        }
        .table table {
            width: 100%;
        }

        .table table #ttd {
            width: 120px;
        }

        .table table td {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-create">
            <h2>Create Product:</h2>
            <form action="/action_page.php" id="form-product-create">
                <label for="name">name:</label><br>
                <input type="text" id="name" name="name" ><br>
                <label for="desc">description:</label><br>
                <input type="text" id="desc" name="desc" ><br>
                <label for="price">price:</label><br>
                <input type="number" min="0" id="price" name="price" ><br>
                <label for="category">category:</label><br>
                <input type="text" id="category" name="category" ><br><br>
                <button type="button" onclick="onCreate()">Create</button>
                <button type="button" onclick="onResetCreate()">Reset</button>
            </form> 
        </div> 
        <div class="table">
            <h2>Product Table:</h2>
            <button type="button" onclick="onRefresh()"><i class="fa-solid fa-retweet"></i>refresh</button>
            <table>
                <tr>
                  <th>No.</th>
                  <th>Name</th>
                  <th>Description</th>
                  <th>price</th>
                  <th>Category</th>
                  <th>Action</th>
                </tr>
                <tbody class="tbody">
                    @foreach ($products as $index => $product)  {{-- indexs => values --}}
                    <tr class="content">
                        <td id="tdid">{{ $index +1 }}</td> 
                        <td>{{ $product->p_name }}</td>
                        <td>{{ $product->p_description }}</td>
                        <td>{{ $product->p_price }}</td>
                        <td>{{ $product->p_category }}</td>
                        <td id="ttd">
                            <button type="button" onclick="onEdit({{$product->id}})"><i class="fas fa-edit"></i> Edit</button>
                            <button type="button" onclick="onDelete({{$product->id}})"><i class="fa-solid fa-trash"></i></button>
                            {{-- <button type="button" onclick="onRemoveRow()"><i class="fa-solid fa-trash"></i></button> --}}
                        </td>
                    </tr>               
                    @endforeach
                </tbody>
              </table>
        </div>
    </div>

    <div class="form-update">
        <h2>Update Product:</h2>
        <form action="/action_page.php" id="form-product-update">
            <input type="hidden" name="" id="idEdit">
            <label for="name">name:</label><br>
            <input type="text" id="nameEdit" name="name" ><br>
            <label for="desc">description:</label><br>
            <input type="text" id="descEdit" name="desc" ><br>
            <label for="price">price:</label><br>
            <input type="number" min="0" id="priceEdit" name="price" ><br>
            <label for="category">category:</label><br>
            <input type="text" id="categoryEdit" name="category" ><br><br>
            <button type="button" onclick="onUpdate()">Update</button>
            <button type="button" onclick="onResetUpdate()">Reset</button>
        </form> 
    </div> 

    <script>
        function onCreate() {
            // console.log('create')
            let data = {
                name: document.querySelector("#name").value,
                description: document.querySelector("#desc").value,
                price: document.querySelector("#price").value,
                category: document.querySelector("#category").value,
            }
            axios({
                url: 'api/create',
                method: 'POST',
                headers: {
                    'Content-type': 'Application/json',
                    // 'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                data: data
            }).then(() => {
                alert('Created !!!')
                onRefresh()
                onResetCreate()
                // location.reload()
            }).catch(error => {
                alert('Error')
            })
        }

        function onEdit(id) {
            // console.log('ok')
            axios({
                url: `api/getById/${id}`,
                method: 'GET'
            }).then(response => {
                console.log(response.data.product)
                let dataObj = response.data.product
                const id = document.querySelector('#idEdit').value = dataObj.id
                const name = document.querySelector('#nameEdit').value = dataObj.p_name
                const desc = document.querySelector('#descEdit').value = dataObj.p_description
                const price = document.querySelector('#priceEdit').value = dataObj.p_price
                const category = document.querySelector('#categoryEdit').value = dataObj.p_category

            }).catch(error => {
                alert("error")
            })
        }

        function onUpdate() {
            let dataUpdate = {
                id: document.querySelector("#idEdit").value,
                name: document.querySelector("#nameEdit").value,
                description: document.querySelector("#descEdit").value,
                price: document.querySelector("#priceEdit").value,
                category: document.querySelector("#categoryEdit").value,
            }

            if (dataUpdate.name === "" && dataUpdate.description === "" && dataUpdate.price === "" && dataUpdate.category === "") {
                alert('No data')
            } else {
                axios({
                    url: 'api/update',
                    method: 'PUT',
                    headers: {
                        'Content-type': 'Application/json',
                        // 'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    data: dataUpdate,
                }).then(() => {
                    onRefresh()
                    onResetUpdate()
                }).catch(error => {
                    alert('error')
                })
            }
        }

        function onDelete(id) {
            axios({
                url: `/api/delete/${id}`,
                method: 'DELETE',
                headers: {
                    'Content-type': 'Application/json',
                }
            }).then((response) => {
                onRemoveRow()
                onRefresh()
            }).catch(error => {
                alert('error')
            })
        }

        function onRefresh() { //  on Refresh event
            document.querySelector('.tbody').innerHTML = "" // reset HTML = null : Class tbody(table)
            axios('api/getAllData')
                .then(response => {
                    let dataAfterRefresh = response.data.data // response is data from api (ProductController)
                    if(dataAfterRefresh) {
                        let count = 1
                        dataAfterRefresh.map(item => { // item is loop data from dataAfterRefresh. => type Object
                            const data = document.querySelector('.tbody')
                            let html = `<tr class="content">
                                        <td id="tdid">${count++}</td> 
                                        <td>${item.p_name}</td>
                                        <td>${item.p_description}</td>
                                        <td>${item.p_price}</td>
                                        <td>${item.p_category}</td>
                                        <td id="ttd">
                                            <button type="button" onclick="onEdit(${item.id})"><i class="fas fa-edit"></i> Edit</button>
                                            <button type="button" onclick="onDelete(${item.id})"><i class="fa-solid fa-trash"></i></button>
                                            {{-- <button type="button" onclick="onRemoveButton()"><i class="fa-solid fa-trash"></i></button> --}}
                                        </td>
                                    </tr>               
                                    `
                                data.insertAdjacentHTML('beforeend', html)
                        })
                    }
                }).catch(error => {
                    alert('Error')
                })
            }

            function onResetCreate() { // reset form create function
                let createId = document.getElementById("form-product-create").reset()
            }

            function onResetUpdate() { // reset form update function
                let updateId = document.getElementById("form-product-update").reset()
            }

/////////////////  JavaScript remove row of table function ///////////////////
        function onRemoveRow() { 
            let getId = document.getElementById('tdid') // get id from data
            // console.log(getId)
            let content = getId.closest('.content')
            console.log(content)
            content.remove()
        }
    </script>
</body>
</html>