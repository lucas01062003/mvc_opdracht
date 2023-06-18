<?php
include "base.php"; ?>
<h1 style="text-align: center">Score bord</h1>
<div class="container  py-5">
    <table class="table table-bordered table-hover bg-white">
        <thead class="thead-dark">
        <tr>
            <th scope="col" colspan="6" class="text-center">robots</th>
        </tr>
        <tr>
            <th scope="col">plaats</th>
            <th scope="col">robot</th>
            <th scope="col">eigenaar</th>
            <th scope="col">overwinningen</th>
            <th scope="col">nederlagen</th>
            <th scope="col">win percentage</th>
        </tr>
        </thead>
        <tbody id="tbody">
        </tbody>
    </table>
</div>
<script>
    axios.get('http://mvc-opdracht.test/robot/score/')
        .then(function (response) {
            document.getElementById('tbody').innerHTML = response.data
        })
        .catch(function (error) {
            console.error(error);
        });
</script>