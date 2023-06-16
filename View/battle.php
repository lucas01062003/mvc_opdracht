<?php
include "base.php"; ?>
<h1 style="text-align: center">Wedstrijd</h1>

<div class="container  py-5">
    <table class="table table-bordered table-hover bg-white">
        <thead class="thead-dark">
        <tr>
            <th scope="col" colspan="7" class="text-center">wedstrijden</th>
        </tr>
        <tr>
            <th scope="col">id</th>
            <th scope="col">robot 1</th>
            <th scope="col">robot 2</th>
            <th scope="col">datum & tijd</th>
            <th scope="col">type</th>
            <th scope="col">winnaar</th>
            <th scope="col">verwijder</th>
        </tr>
        </thead>
        <tbody id="tbody">
        </tbody>
    </table>
</div>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <h1 class="mb-3 text-center">Wedstrijd toevoegen / aanpassen</h1>
            <form method="post" id="battle-form" action="alter/">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="battle-id" class="form-label">id (voor aanpassen)</label>
                        <input type="text" class="form-control" id="battle-id" name="battle-id">
                    </div>
                    <div class="col-md-6">
                        <label for="battle-date" class="form-label">datum en tijd</label>
                        <input type="datetime-local" class="form-control" id="battle-date" name="battle-date" required>
                    </div>
                    <div class="col-md-6">
                        <label for="battle-type" class="form-label">type</label>
                        <select class="form-control" id="battle-type" name="battle-type" required>
                            <option value=""></option>
                            <option value="5 min max">5 min max</option>
                            <option value="10 min max">10 min max</option>
                            <option value="20 min max">20 min max</option>
                        </select>
<!--                        <input type="text" class="form-control" id="battle-type" name="battle-type" required>-->
                    </div>
                    <div class="col-md-6">
                        <label for="battle-r1" class="form-label">robot 1</label>
                        <select class="form-control" id="r-1-select" name="r-1-select" required>
                            <option value=""></option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label for="battle-r2" class="form-label">robot 2</label>
                        <select class="form-control" id="r-2-select" name="r-2-select" required>
                            <option value=""></option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label for="battle-winner" class="form-label">winnaar (id)</label>
                        <input class="form-control" id="battle-winner" name="battle-winner" required>
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
    axios.get('http://mvc-opdracht.test/battle/get/')
        .then(function (response) {
            document.getElementById('tbody').innerHTML = response.data
        })
        .catch(function (error) {
            console.error(error);
        });

    axios.get('http://mvc-opdracht.test/robot/options/')
        .then(function (response) {
            document.getElementById('r-1-select').innerHTML += response.data
            document.getElementById('r-2-select').innerHTML += response.data
        })
        .catch(function (error) {
            console.error(error);
        });

    function deletebattle(id) {
        id = id.replace("delete-", "");

        const config = {
            headers: {
                'Content-Type': 'application/json',
                'X-Delete-Id': id
            }
        };

        axios.delete('http://mvc-opdracht.test/battle/delete/', config)
            .then(function (response) {
                this.location.reload();
            })
            .catch(function (error) {
                console.error(error);
            });
    }
</script>