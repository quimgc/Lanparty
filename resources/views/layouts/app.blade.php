<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user" content="{{ logged_user() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons' rel="stylesheet">
    <link href="https://unpkg.com/vuetify@1.0.0-beta.6/dist/vuetify.min.css" rel="stylesheet">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">

   <v-app id="inspire">
                <v-navigation-drawer
                        fixed
                        clipped
                        app
                        v-model="drawer"
                >
                    <v-list dense>
                        <template v-for="(item, i) in items">
                            <v-layout
                                    row
                                    v-if="item.heading"
                                    align-center
                                    :key="i"
                            >
                                <v-flex xs6>
                                    <v-subheader v-if="item.heading">
                                        @{{ item.heading }}
                                    </v-subheader>
                                </v-flex>
                            </v-layout>
                            <v-list-group v-else-if="item.children" v-model="item.model" no-action>
                                <v-list-tile slot="item" @click="menuItemSelected(item)">
                                    <v-list-tile-action>
                                        <v-icon>@{{ item.model ? item.icon : item['icon-alt'] }}</v-icon>
                                    </v-list-tile-action>
                                    <v-list-tile-content>
                                        <v-list-tile-title>
                                            @{{ item.text }}
                                        </v-list-tile-title>
                                    </v-list-tile-content>
                                </v-list-tile>
                                <v-list-tile
                                        v-for="(child, i) in item.children"
                                        :key="i"
                                        @click="menuItemSelected(child)"
                                >
                                    <v-list-tile-action v-if="child.icon">
                                        <v-icon>@{{ child.icon }}</v-icon>
                                    </v-list-tile-action>
                                    <v-list-tile-content>
                                        <v-list-tile-title>
                                            @{{ child.text }}
                                        </v-list-tile-title>
                                    </v-list-tile-content>
                                </v-list-tile>
                            </v-list-group>
                            <v-list-tile v-else @click="menuItemSelected(item)">
                                <v-list-tile-action>
                                    <v-icon>@{{ item.icon }}</v-icon>
                                </v-list-tile-action>
                                <v-list-tile-content>
                                    <v-list-tile-title>
                                        @{{ item.text }}
                                    </v-list-tile-title>
                                </v-list-tile-content>
                            </v-list-tile>
                        </template>
                    </v-list>
                </v-navigation-drawer>
                <v-toolbar
                        color="blue darken-3"
                        dark
                        app
                        clipped-left
                        clipped-right
                        fixed
                >
                    <v-toolbar-title :style="$vuetify.breakpoint.smAndUp ? 'width: 300px; min-width: 250px' : 'min-width: 72px'" class="ml-0 pl-3">
                        <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>
                        <span class="hidden-xs-only">{{ config('app.shortname', 'Laravel') }}</span>
                    </v-toolbar-title>
                    <div class="d-flex align-center" style="margin-left: auto">
                        <v-btn icon>
                            <v-icon>notifications</v-icon>
                        </v-btn>
                        <v-btn icon large @click="toogleRightDrawer">
                            <gravatar :user="{{ $user }}" size="52px"></gravatar>
                        </v-btn>
                    </div>
                </v-toolbar>
               <v-navigation-drawer
                       fixed
                       v-model="drawerRight"
                       right
                       clipped
                       app
               >
                   <v-card>
                       <v-container fluid grid-list-md class="grey lighten-4">
                           <v-layout row wrap>
                               <v-flex xs12 md4>
                                   <gravatar :user="{{ $user }}" size="100px"></gravatar>
                               </v-flex>
                               <v-flex xs12 md8>
                                   <h3>{{ $user->name }}</h3>
                               </v-flex>
                           </v-layout>
                       </v-container>
                       <v-card-text class="px-0 grey lighten-3">
                           <v-form class="pl-3 pr-1 ma-0">
                               <v-text-field readonly
                                             label="Email"
                                             value="{{ $user->email }}"
                                             readonly
                               ></v-text-field>
                               <v-text-field readonly
                                             label="Nom usuari"
                                             value="{{ $user->name }}"
                                             readonly
                               ></v-text-field>
                               <v-text-field readonly
                                             label="Nom"
                                             value="{{ $user->givenName }}"
                                             readonly
                               ></v-text-field>
                               <v-text-field readonly
                                             label="1r Cognom"
                                             value="{{ $user->sn1 }}"
                                             readonly
                               ></v-text-field>
                               <v-text-field readonly
                                             label="2n Cognom"
                                             value="{{ $user->sn2 }}"
                                             readonly
                               ></v-text-field>
                           </v-form>
                       </v-card-text>
                       <v-card-actions>
                           <v-btn flat color="orange">Editar</v-btn>
                           <v-btn :loading="logoutLoading" @click="logout" flat color="orange">Sortir</v-btn>
                       </v-card-actions>
                   </v-card>

               </v-navigation-drawer>
                <v-content>
                    @yield('content')
                </v-content>
                <v-btn
                        fab
                        bottom
                        right
                        color="pink"
                        dark
                        fixed
                        @click.stop="dialog = !dialog"
                >
                    <v-icon>add</v-icon>
                </v-btn>
                <v-dialog v-model="dialog" width="800px">
                    <v-card>
                        <v-card-title
                                class="grey lighten-4 py-4 title"
                        >
                            Create contact
                        </v-card-title>
                        <v-container grid-list-sm class="pa-4">
                            <v-layout row wrap>
                                <v-flex xs12 align-center justify-space-between>
                                    <v-layout align-center>
                                        <v-avatar size="40px" class="mr-3">
                                            <img
                                                    src="//ssl.gstatic.com/s2/oz/images/sge/grey_silhouette.png"
                                                    alt=""
                                            >
                                        </v-avatar>
                                        <v-text-field
                                                placeholder="Name"
                                        ></v-text-field>
                                    </v-layout>
                                </v-flex>
                                <v-flex xs6>
                                    <v-text-field
                                            prepend-icon="business"
                                            placeholder="Company"
                                    ></v-text-field>
                                </v-flex>
                                <v-flex xs6>
                                    <v-text-field
                                            placeholder="Job title"
                                    ></v-text-field>
                                </v-flex>
                                <v-flex xs12>
                                    <v-text-field
                                            prepend-icon="mail"
                                            placeholder="Email"
                                    ></v-text-field>
                                </v-flex>
                                <v-flex xs12>
                                    <v-text-field
                                            type="tel"
                                            prepend-icon="phone"
                                            placeholder="(000) 000 - 0000"
                                            mask="phone"
                                    ></v-text-field>
                                </v-flex>
                                <v-flex xs12>
                                    <v-text-field
                                            prepend-icon="notes"
                                            placeholder="Notes"
                                    ></v-text-field>
                                </v-flex>
                            </v-layout>
                        </v-container>
                        <v-card-actions>
                            <v-btn flat color="primary">More</v-btn>
                            <v-spacer></v-spacer>
                            <v-btn flat color="primary" @click="dialog = false">Cancel</v-btn>
                            <v-btn flat @click="dialog = false">Save</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
            </v-app>
    </div>
    @stack('beforeScripts')
    <script src="{{ mix('js/app.js') }}"></script>
    @stack('afterScripts')
</body>
</html>
