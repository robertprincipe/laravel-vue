<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 mt-4">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Usuarios</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-warning" @click="newModal">
                        Registrar
                        <i class="fas fa-user-plus fa-fw"></i>
                    </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Nombre</th>
                      <th>Correo</th>
                      <th>Rol</th>
                      <th>Fecha de registro</th>
                      <th>Modificar</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="user in users" :key="user.id">
                      <td>{{ user.id }}</td>
                      <td>{{ user.name }}</td>
                      <td>{{ user.email }}</td>
                      <td>{{ user.type | capitalize }}</td>
                      <td>{{ user.created_at | dateFormat }}</td>
                      <td>
                        <a href="#" @click.prevent="editModal(user)"><i class="fas fa-edit blue"></i></a>
                            /
                        <a href="#" @click.prevent="deleteUser(user)"><i class="fas fa-trash red"></i></a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <div class="modal fade" id="newUser" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                          {{ editMode ? 'Actualizar usuario' : 'Registrar usuario'  }}
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form @submit.prevent="editMode ? updateUser() : createUser()">
                      <div class="modal-body">
                        <div class="form-group">
                          <input class="form-control" type="text" id="name" name="name" v-model="form.name" :class="{'is-invalid': form.errors.has('name')}" placeholder="Nombre">
                          <has-error :form="form" field="name"></has-error>
                        </div>
                        <div class="form-group">
                          <input class="form-control" type="text" id="email" name="email" v-model="form.email" :class="{'is-invalid': form.errors.has('email')}" placeholder="Correo Electronico">
                          <has-error :form="form" field="email"></has-error>
                        </div>
                        <div class="form-group">
                          <textarea class="form-control" id="bio" name="bio" v-model="form.bio" :class="{'is-invalid': form.errors.has('bio')}" placeholder="Ingrese su biografia (Opcional)"></textarea>
                          <has-error :form="form" field="bio"></has-error>
                        </div>
                        <div class="form-group">
                          <select class="form-control" type="text" id="type" name="type" v-model="form.type" :class="{'is-invalid': form.errors.has('type')}" placeholder="Nombre">
                            <option value="" disabled selected>Seleccione el rol de usuario</option>
                            <option value="admin">Administrador</option>
                            <option value="author">Autor</option>
                            <option value="user">Usuario</option>
                          </select>
                          <has-error :form="form" field="name"></has-error>
                        </div>
                        <div class="form-group">
                          <input class="form-control" type="password" id="password" name="password" v-model="form.password" :class="{'is-invalid': form.errors.has('password')}" placeholder="Contraseña">
                          <span v-show="editMode" class="small text-muted">
                            Solo rellene este campo si quiere cambiar la contraseña
                          </span>
                          <has-error :form="form" field="password"></has-error>
                        </div>
                      </div>

                      <div class="modal-footer justify-content-between">
                          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                          <button type="submit" class="btn" :class="{
                            'btn-primary': editMode,
                            'btn-success': !editMode
                          }">
                            {{ editMode ? 'Actualizar' : 'Guardar' }}
                          </button>
                      </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>

</template>

<script>
    export default {
      data() {
        return {
          editMode: false,
          users: {},
          form: new Form({
            id: '',
            name: '',
            email: '',
            password: '',
            type: '',
            bio: '',
            photo: ''
          })
        }
      },
      methods: {
        newModal() {
          this.editMode = false;
          $('#newUser').modal('show');
          this.form.reset();
        },
        editModal(user) {
          this.editMode = true;
          $('#newUser').modal('show');
          this.form.reset();
          this.form.fill(user);
        },
        listUsers() {
          axios.get('api/user')
            .then(({data}) => this.users = data.data)
        },
        createUser() {
          console.log(this.form)
          this.$Progress.start();
          this.form.post('api/user')
            .then(resp => {
              console.log(resp);
              if (resp.status == 201) {
                $('#newUser').modal('hide');
                Fire.$emit('UpdateUsers');
                toast.fire({
                  type: 'success',
                  title: 'El usuario se registro correctamente'
                });
              }
              this.$Progress.finish();
            })
            .catch(err => {
              toast.fire({
                type: 'error',
                title: 'Hubo un error en el registro'
              })
            });
        },
        updateUser() {
          this.$Progress.start();
          this.form.put(`api/user/${this.form.id}`)
            .then(resp => {
              if (resp.status === 200) {
                $('#newUser').modal('hide');
                toast.fire({
                  title: resp.data.message,
                  type: 'success'
                })
                Fire.$emit('UpdateUsers');
                this.$Progress.finish();
              } else {
                this.$Progress.fail();
              }
            })
            .catch(() => {
              toast.fire({
                title: 'No se pudo actualizar el usuario',
                type: 'error'
              })
              this.$Progress.fail();
            });
        },
        deleteUser(user) {
          swal.fire({
            title: 'Desea eliminar este usuaio',
            type: 'warning',
            text: 'El usuario se eliminara permanentemente',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, quiero eliminarlo',
            cancelButtonText: 'No'
          })
          .then(result => {
            if (result.value) {
              this.form.delete(`api/user/${user.id}`)
              .then((resp => {
                if (resp.status === 200) {
                  let index = this.users.indexOf(user);
                  if (index > -1) {this.users.splice(index, 1)}
                  toast.fire({
                    title: resp.data.message,
                    type: 'success'
                  })
                }
              }))
              .catch(() => {
                toast.fire({
                  title: 'Se produjo un error',
                  type: 'error'
                })
              })
            }
          })
        }
      },
      mounted() {
        this.listUsers();
        Fire.$on('UpdateUsers', () => {
          this.listUsers();
        })
      }
    }
</script>
