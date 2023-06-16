<?php
include "base.php"; ?>
<h1 style="text-align: center">Robots</h1>

<div class="container  py-5">
    <table class="table table-bordered table-hover bg-white">
        <thead class="thead-dark">
        <tr>
            <th scope="col" colspan="7" class="text-center">robots</th>
        </tr>
        <tr>
            <th scope="col">id</th>
            <th scope="col">naam</th>
            <th scope="col">eigenaar</th>
            <th scope="col">wapen</th>
            <th scope="col">bepansering</th>
            <th scope="col">voortbeweging</th>
            <th scope="col">verwijderen</th>
        </tr>
        </thead>
        <tbody id="tbody">
        </tbody>
    </table>
</div>


<script>
    axios.get('http://mvc-opdracht.test/robot/get/')
        .then(function (response) {
            document.getElementById('tbody').innerHTML = response.data
        })
        .catch(function (error) {
            console.error(error);
        });

    function deleteRobot(id) {
        id = id.replace("delete-", "");

        const config = {
            headers: {
                'Content-Type': 'application/json',
                'X-Delete-Id': id
            }
        };

        axios.delete('http://mvc-opdracht.test/robot/delete/', config)
            .then(function (response) {
                this.location.reload();
            })
            .catch(function (error) {
                console.error(error);
            });
    }
</script>