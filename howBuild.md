# LarVue

## Primer Dia
```
    composer create-project laravel/laravel "6" "LarVue"
```

```
composer laravel/ui --dev
```

```
php artisan ui vue
```

```
npm install && npm run watch
```

```
php artisan ui:auth
```

```
php artisan migrate
```


### Añadir fontawesome con sass
achivo app.sass
```sass
$fa-font-path: '../webfonts';
@import '~admin-lte/dist/css/adminlte.css';

@import '~@fortawesome/fontawesome-free/scss/fontawesome.scss';
@import '~@fortawesome/fontawesome-free/scss/solid.scss';
@import '~@fortawesome/fontawesome-free/scss/brands.scss';
```

### Añadir js de admin-lte
archivo bootstrap.js
``` javascript
require('admin-lte');
```

### Copiar el archivo starter.html de admin-lte

### VueRouter instalar y configurar
instalar
```
npm install vue-router
```

configuración | resources/js/app.js
```javascript
import VueRouter from 'vue-router'
Vue.use(VueRouter)
const routes = [
        {path: 'uri',component: Component}
]
const router = new VueRouter({
    routes,
    mode: 'history' // url sin #
})
```
### Añadir rutas en la panel.blade.php
```
<router-link to="/uri" active-class="active"></router-link>
```

-------------------------------------------------------------------------------
## Segundo Dia





## Tercer Dia



```
npm install moment
```

app.js

```javascript
Vue.filter('formatDate', date => {
    if (!date) return ''
    return moment(date).format('MMMM Do YYYY')
})
```

UsersComponent.vue

```vue
<th>{{ user.created_at | formatDate }}</th>
```

VueProgressBar

```
npm install vue-progressbar
```

app.js

```javascript
import VueProgressBar from 'vue-pregressbar'
Vue.use(VueProgressBar, {
    color: 'color',
    failedColor: 'colorFialed',
  	height: 2px,
})
```

panel.blade.php

```php+HTML
<router-view></router-view>
<vue-progress-bar></vue-progress-bar>
```

UsersComponent.vue

````javascript
this.$Progress.start()
this.$Progress.finish()
````

```
npm install sweetalert2
```

app.js

```javascript
import swal from 'swal'
const toast = swal({
	toast: true,
	
})
window.toast = toast
```

