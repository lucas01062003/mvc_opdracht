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
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <h1 class="mb-3 text-center">Robot toevoegen / aanpassen</h1>
            <form method="post" id="robot-form" action="alter/">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="robot-id" class="form-label">id (voor aanpassen)</label>
                        <input type="text" class="form-control" id="robot-id" name="robot-id">
                    </div>
                    <div class="col-md-6">
                        <label for="robot-name" class="form-label">naam</label>
                        <input type="text" class="form-control" id="robot-name" name="robot-name" required>
                    </div>
                    <div class="col-md-6">
                        <label for="robot-owner" class="form-label">eigenaar</label>
                        <input type="text" class="form-control" id="robot-owner" name="robot-owner" required>
                    </div>
                    <div class="col-md-6">
                        <label for="robot-weapon" class="form-label">wapen</label>
                        <input type="text" class="form-control" id="robot-weapon" name="robot-weapon" required>
                    </div>
                    <div class="col-6">
                        <label for="robot-armour" class="form-label">bepansering</label>
                        <input class="form-control" id="robot-armour" name="robot-armour" required>
                    </div>
                    <div class="col-6">
                        <label for="robot-propulsion" class="form-label">voortbeweging</label>
                        <input class="form-control" id="robot-propulsion" name="robot-propulsion" required>
                    </div>

                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <br>
                                <button type="submit" class="btn btn-dark w-100 fw-bold" >opslaan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
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