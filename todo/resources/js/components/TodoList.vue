<template>
    <div class="row">
        <div class="alert alert-success hidden" id="success"></div>
        <div class="alert alert-danger hidden" id="failure"></div>

        <div class="col-md-6 align-self-center">
            <ul class="list-group" style="width: 500px; margin: 0 auto;">
                <li class="list-group-item" v-model="itemsModel" v-if="items" v-for="item in items" :key="item.id">
                    <a @click="details(item.id)" style="color: cornflowerblue">{{item.title}}</a>
                    <span class="float-end">{{item.due_date}}</span>
                </li>
            </ul>
            <div class="col-md-12 text-center">
                <button class="btn-default btn btn-primary mt-2" @click="update" id="update">Refresh List</button>
                <button class="btn-default btn btn-primary mt-2" @click="create">Create New Item</button>
            </div>
        </div>
        <div class="col-md-6">
            <div class="hidden" id="details">
                <h2 v-if="detailsView">{{ detailsView.title}}</h2>
                <div>
                    <span class="details-date" v-if="detailsView"><b>Due Date: </b>{{ detailsView.due_date}}</span>
                    <span v-if="detailsView">{{ detailsView.content}}</span>
                </div>
            </div>
            <div id="create">
                <form class="mt-4 p-4" id="createForm">
                    <input type="hidden" name="_token" :value="csrf">
                    <div class="form-group m-3">
                        <label for="title">Todo Name</label>
                        <input type="text" class="form-control" name="title">
                    </div>
                    <div class="form-group m-3">
                        <label for="due_date">Due Date</label>
                        <input type="date" class="form-control" name="due_date">
                    </div>
                    <div class="form-group m-3">
                        <label for="content">Todo Description</label>
                        <textarea class="form-control" name="content" rows="3"></textarea>
                    </div>
                    <input type="submit" class="btn-default btn btn-primary mt-2" @click="store" value="Save Item">
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        data() {
            return {
                itemsModel: 0,
                items: null,
                detailsView: null,
                csrf: document.head.querySelector('meta[name="csrf-token"]').content
            };
        },
        mounted () {
            axios.get("/api/items").then(response => (this.items = response.data));
            setInterval(function() {
                axios.get("/api/items").then(response => (this.items = response.data));
            },15000);
        },
        methods: {
            update() {
                axios.get("/api/items").then(response => (this.items = response.data));
            },
            details(itemId) {
                $('#create').hide();
                $('#details').show();
                axios.get("/api/item/" + itemId).then(response => (this.detailsView = response.data));
            },
            create() {
                $('#create').show();
                $('#details').hide();
            },
            store() {
                console.log("Saving!");
                $('#createForm').on('submit', function(e) {
                    e.preventDefault();
                    let userinfo = $(this).serializeArray();
                    let user = {};
                    userinfo.forEach((value) => {
                        user[value.name] = value.value;
                    });
                    let url = "/store";
                    $.ajax({
                        method: "POST",
                        url: url,
                        data: user
                    }).done(function(msg) {
                        $('#failure').hide();
                        $('#success').show();
                        $('#success').html('Saved Successfully...<span class="close float-end"><i class="fas fa-times-circle"></i></span>');
                        $('#update').click();
                    }).fail(function(err, textstatus, error) {
                        $('#success').hide();
                        $('#failure').show();
                        $('#failure').html('Failed to save...<span class="close float-end"><i class="fas fa-times-circle"></i></span>');
                    });
                });
                $('.close').click(function() {
                   $('#failure').hide();
                   $('#success').hide();
                });
                $('#failure').click(function() {
                    $('#failure').hide();
                });
                $('#succes').click(function() {
                    $('#success').hide();
                });
            }
        }
    }
</script>
