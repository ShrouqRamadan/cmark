<template>


      <div class="wrapper" >
          <header style="color: #6f42c1; ;text-align: center">Todo App</header>
          <span v-if="error" class="text-danger">{{error}}</span>
          <form>
              <div class="inputField">
                  <input type="text" v-model="task"  placeholder="Add your new todo">

                  <button @click.prevent="addTask()" class="btn">+</button>
              </div>

          </form>

          <ul id="incomplete-tasks" v-for="task in tasks" v-bind:key="task.id">
              <li>
                  <input class="form-check-input" type="checkbox" @click="update(task.id)">
                  <label>{{ task.name }}</label><input type="text" >
<!--                  <button  @click.prevent="deletetask(task.id)" class="delete">Delete</button>-->
                 <button  @click.prevent="deletetask(task.id)" class="delete" >delete</button>
                  </li>
          </ul>

          <h3 v-if="task_incomplate != ''">Completed</h3>
          <ul id="completed-tasks" v-if="task_incomplate != ''"   v-for="task in task_incomplate" v-bind:key="task.id">
              <li> <input class="form-check-input" type="checkbox" @click="update(task.id)" checked  >
                  <label>{{ task.name }}</label>
                  <button @click.prevent="deletetask(task.id)" class="delete">delete</button></li>
          </ul>



          <div class="footer">
              <span>You have <span class="pendingTasks"></span> pending tasks</span>
              <button  @click.prevent="deleteAll()" >Clear All</button>
          </div>
      </div>

</template>


<script>
    export default {
        created() {
            this.gettasks();
            this.incomplate();
        },

        data: function (){
            return {
                task: null,
                error: null,
                user_task: {
                    name: null,

                },
                tasks : [],
                task_incomplate:[]
            }},

        methods:{
            async   addTask(){
                if (this.task){
                    this.error = null;
                  await  axios.post('/api/task', {name :this.task}).then(
                        response => {
                            if (response.data.status ==  'error'){
                                this.error = response.data.error


                            }
                            this.error=''
                            this.task=''
                          this.gettasks();
                        }
                    ).catch(error => {
                        console.log(error);
                    })
                }else{
                    this.error = 'please enter task title'

                }

            },
            async gettasks(){
                await  axios.get('/api/task/complate').then(
                    response => {
                        this.tasks = response.data
                    }

                ).catch(error => error.data);
            },
            async incomplate(){
                await  axios.get('/api/task/incomplate').then(
                    response => {
                        this.task_incomplate = response.data
                    }

                ).catch(error => error.data);
            },
           async deletetask(id){
               await axios.post('/api/task/delete',{id:id}).then(response => {
                    this.gettasks();
                    this.incomplate();
                }).catch(error => error.data);
            },
          async  deleteAll(){
               await axios.get('/api/task/delete/all').then(response => {
                    this.incomplate();
                    this.gettasks();
                })
                    .catch(error => error.data);
            },

           async update(id){
               await axios.post('/api/task/update',{id:id}).then(response => {
                    this.incomplate();
                    this.gettasks();
                }).catch(error => error.data);
            },




        }


    }
</script>

<style scoped>

ul {
    margin: 0;
    padding: 0;
}

li * {
    float: left;
}

li,
h3 {
    clear: both;
    list-style: none;
}

input,
button {
    /*outline: none;*/
}

button {
    background: none;
    border: 0px;
    color: #888;
    font-size: 15px;
    width: 80px;
    /*margin-left: 5px;*/


    /*cursor: pointer;*/
}

button:hover {
    color: #333;
}


/* Heading */

h3,
label[for='new-task'] {
    color: #333;
    font-weight: 700;
    font-size: 15px;
    border-bottom: 2px solid #333;
    padding: 20px 0 10px;
    margin: 0;
    text-transform: uppercase;
}

input[type="text"] {
    margin: 0;
    font-size: 18px;
    line-height: 18px;
    height: 18px;
    padding: 10px;
    border: 1px solid #ddd;
    background: #fff;
    border-radius: 6px;

    color: #888;
}

input[type="text"]:focus {
    color: #333;
}


/* New Task */

label[for='new-task'] {
    display: block;
    margin: 0 0 20px;
}

input#new-task {
    float: left;
    width: 318px;
}

p > button:hover {
    color: #0FC57C;
}


/* Task list */

li {
    overflow: hidden;
    padding: 20px 0;
    margin-left: 5px;
    border-bottom: 1px solid #eee;
}
li > .delete{
    margin-left: 150px;
    font-size: 20px;
    font-weight: 500;
    color:red
}


li > input[type="checkbox"] {
    margin: 0 10px;
    position: relative;
    top: 15px;
}

li > label {
    font-size: 18px;
    line-height: 40px;
    width: 237px;
    padding: 0 0 0 11px;
}

li > input[type="text"] {
    width: 226px;
}

li > .delete:hover {
    color: #CF2323;
}


/* Completed */

#completed-tasks label {
    text-decoration: line-through;
    color: #888;
}


/* Edit Task */

ul li input[type=text] {
    display: none;
}

ul li.editMode input[type=text] {
    display: block;
}

ul li.editMode label {
    display: none;
}
*{
    margin: 0;
    padding: 0;
    box-sizing: border-box;

}
::selection{
    color: #ffff;
    background: rgb(91, 4, 204);
}
body{
    width: 100%;
    height: 100vh;
    /* overflow: hidden; */
    padding: 10px;
    background: linear-gradient(to bottom, #68EACC 0%, #1b3263 100%);
}
.wrapper{
    background: #fff;
    max-width: 600px;
    width: 100%;
    margin: 120px auto;
    padding: 25px;
    border-radius: 5px;
    box-shadow: 0px 10px 15px rgba(0,0,0,0.1);
}
.wrapper header{
    font-size: 30px;
    font-weight: 600;
}
.wrapper .inputField{
    margin: 20px 0;
    width: 100%;
    display: flex;
    height: 45px;
}
.inputField input{
    width: 100%;
    height: 100%;
    outline: none;
    border-radius: 3px;
    border: 1px solid #ccc;
    font-size: 17px;
    padding-left: 15px;
    transition: all 0.3s ease;
}
.inputField input:focus{
    border-color: #6600eb;
}
.inputField button{
    width: 50px;
    height: 100%;
    border: none;
    color: #fff;
    margin-left: 5px;
    font-size: 21px;
    background: #6600eb;
    cursor: pointer;
    border-radius: 3px;
    opacity: 0.6;

    transition: all 0.3s ease;
}
.inputField button:hover,
.footer button:hover{
    background: #6600eb;
}
.inputField button.active{
    opacity: 1;
    pointer-events: auto;
}
.wrapper .todoList{
    max-height: 250px;
    overflow-y: auto;
}
table td{
    position: relative;

    margin-bottom: 8px;
    background: #f2f2f2;
    border-radius: 3px;
    padding: 10px 15px;
    cursor: default;
    overflow: hidden;
    word-wrap: break-word;
}
.todoList li .icon{
    /*position: absolute;*/
    /*right: -45px;*/
    /*top: 50%;*/
    /*transform: translateY(-50%);*/
    /*background: #e74c3c;*/
    /*width: 45px;*/
    /*text-align: center;*/
    /*color: #fff;*/
    /*padding: 10px 15px;*/
    /*border-radius: 0 3px 3px 0;*/
    /*cursor: pointer;*/
    /*transition: all 0.2s ease;*/
}
.todoList li:hover .icon{
    right: 0px;
}
.wrapper .footer{
    display: flex;
    width: 100%;
    margin-top: 20px;
    align-items: center;
    justify-content: space-between;
}
.footer button{
    padding: 6px 10px;
    border-radius: 3px;
    border: none;
    outline: none;
    color: #fff;
    font-weight: 400;
    font-size: 16px;
    margin-left: 5px;
    background: #6600eb;
    cursor: pointer;
    user-select: none;
    opacity: 0.6;
    transition: all 0.3s ease;
}
.footer button.active{
    opacity: 1;
    pointer-events: auto;
}
</style>
