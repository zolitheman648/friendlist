<template>
  <div id="app">
    <div class="container">
      <div class="row">
        <div class="col-md-8 offset-md-2">
          <br>
          <h2>Felhasználók</h2>
          <hr>
          <ul class="list-group">
            <transition-group name="users" mode="out-in">
            <li v-for="user in users" :key="user.rowid" class="list-group-item" :class="{deactivated:!parseInt(user.service)}">
              {{user.name}} - {{user.mail}}
              <div class="edit_user" @click="editUserInit(user.rowid)" title="Szerkesztés">	&#9881;</div>
              <div class="del_user" @click="delUser(user.rowid)" title="Eltávolít">&times;</div>
            </li>
            </transition-group>
          </ul>
          <br>
          <button class="btn btn-primary" @click="addUser = !addUser">Új felhasználó</button>
          <transition name="overlay-fade">
            <div class="overlay" v-if="(addUser || modID)" @click="addUser = false;modID = false"></div>
          </transition>
          <transition name="popup">
            <div class="form-container" v-if="addUser">
              <h2>Felhasználó hozzáadása</h2>
              <div class="form-group">
                <label for="exampleInputPassword1">Név</label>
                <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Név" v-model="name">
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">E-mail cím</label>
                <input type="email" class="form-control" id="exampleInputEmail1" placeholder="E-mail cím" v-model="mail">
              </div>
              <button class="btn btn-primary" @click="addUsers">Felvétel</button>
            </div>
          </transition>
          <transition name="popup">
          <div class="form-container" v-if="modID">
            <h2>Felhasználó szerkesztése</h2>
            <div class="form-group">
              <label for="exampleInputPassword1">Felhasználó neve</label>
              <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Név" v-model="modName">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Felhasználó e-mail címe</label>
              <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="E-mail cím" v-model="modMail">
            </div>
            <div class="form-group form-check">
              <input type="checkbox" class="form-check-input" id="exampleCheck1" v-model="modActive">
              <label class="form-check-label" for="exampleCheck1">Aktív</label>
            </div>
            <button type="submit" class="btn btn-primary" @click="editUser">Módosít</button>
          </div>
          </transition>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

export default {
  data() {
    return {
      users: [],
      addUser: false,
      name: '',
      mail: '',
      modID: '',
      modName: '',
      modMail: '',
      modActive: ''
    }
  },
  methods: {
    updateUsers(){
      var request = new XMLHttpRequest();
      request.open('GET', 'http://localhost:8090/api2.php', true);

      var self = this;
      request.onload = function() {
        if (this.status >= 200 && this.status < 400) {
          // Success!
          var data = JSON.parse(this.response);
          self.users = data;
        } else {
          // We reached our target server, but it returned an error

        }
      };

      request.onerror = function() {
        // There was a connection error of some sort
      };

      request.send();
    },
    addUsers(){
      var request = new XMLHttpRequest();
      request.open('POST', 'http://localhost:8090/api2.php', true);
      request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
      request.send(`name=${this.name}&mail=${this.mail}`);

      let _this = this;
      request.onload = function(){
        if (this.status >= 200 && this.status < 400) {
          // Success!
          _this.addUser = false;
          _this.updateUsers();
        } else {
          // We reached our target server, but it returned an error

        }
      }

    },
    delUser(userID){
      var request = new XMLHttpRequest();
      request.open('DELETE', 'http://localhost:8090/api2.php', true);
      request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
      request.send(`id=${userID}`);

      let _this = this;
      request.onload = function(){
        if (this.status >= 200 && this.status < 400) {
          // Success!
          _this.updateUsers();
        } else {
          // We reached our target server, but it returned an error

        }
      }
    },
    editUserInit(userID){
      let userEdit = this.users.find(x => x.rowid === userID);

      this.modID = userEdit.rowid;
      this.modName = userEdit.name;
      this.modMail = userEdit.mail;
      this.modActive = parseInt(userEdit.service);
    },
    editUser(){
      var request = new XMLHttpRequest();
      request.open('PUT', 'http://localhost:8090/api2.php', true);
      request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
      request.send(`id=${this.modID}&name=${this.modName}&mail=${this.modMail}&service=${this.modActive}`);

      let _this = this;
      request.onload = function(){
        if (this.status >= 200 && this.status < 400) {
          // Success!
          _this.modID = '';
          _this.modName = '';
          _this.modMail = '';
          _this.modActive = '';
          _this.updateUsers();
        } else {
          // We reached our target server, but it returned an error

        }
      }
    }
  },
  created(){
    this.updateUsers();
  }
}
</script>

<style scoped>
  .list-group-item{
    position: relative;
    padding-right:85px;
  }

  .list-group-item.deactivated{
    color: #999;
  }

  .edit_user{
    position:absolute;
    z-index:100;
    right:45px;
    top:50%;
    transform:translateY(-50%);
    cursor:pointer;
    width:30px;
    height:30px;
    line-height:32px;
    text-align:center;
    border-radius:4px;
    background: #169c43;
    color: #ffffff;
    opacity:.9;
    font-size:32px;
    padding-right:1px;
  }

  .del_user{
    position:absolute;
    z-index:100;
    right:10px;
    top:50%;
    transform:translateY(-50%);
    cursor:pointer;
    width:30px;
    height:30px;
    line-height:32px;
    text-align:center;
    border-radius:4px;
    background: #f45f25;
    color: #ffffff;
    opacity:.9;
    font-size:32px;
    padding-right:1px;
  }

  .del_user:hover, .edit_user:hover{
    opacity:1;
  }

  .overlay{
    position:fixed;
    top:0;
    bottom:0;
    left:0;
    right:0;
    background: rgba(0,0,0,.2);
  }

  .form-container{
    position: fixed;
    left:50%;
    top:50%;
    transform: translate(-50%, -50%);
    background: #ffffff;
    padding: 20px 25px;
    border-radius: 4px;
    box-shadow: 0px 1px 15px -5px rgba(0,0,0,.4);
  }

  .overlay-fade-enter{
    opacity:0;
  }

  .overlay-fade-enter-active{
    transition: opacity .3s ease-out;
  }

  .overlay-fade-leave-active{
    opacity:0;
    transition: opacity .3s ease-out;
  }

  .popup-enter{
    opacity: 0;
    transform: translateY(calc(-50% + 30px)) translateX(-50%);
  }

  .popup-enter-active{
    transition: all .3s ease-out;
  }

  .popup-leave-active{
    opacity:0;
    transform: translateY(calc(-50% + 30px)) translateX(-50%);
    transition: all .3s ease-out;
  }

  .users-enter{
    opacity:0;
  }

  .users-enter-active{
    transition: opacity .3s ease-out;
  }

  .users-leave-active{
    opacity:0;
    transition: opacity .3s ease-out, height .3s ease-out;
    position: absolute;
    width:100%;
  }

  .users-move {
    transition: transform 1s;
  }

  .list-group{
    position: relative;
  }
</style>
