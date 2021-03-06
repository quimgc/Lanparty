<template>
    <div>
        <v-dialog v-model="showInscribeToGroupEvent" max-width="500px">
            <group
                :event="currentEvent"
                @close="showInscribeToGroupEvent=false;inscriptions[currentEvent.id] = false;"
                :dialog="true"
            ></group>
        </v-dialog>
        <v-card>
            <v-card-title class="blue darken-3 white--text"><h2>Events</h2></v-card-title>
            <v-card-text class="px-0 mb-2">
                <v-data-table
                        :headers="headers"
                        :items="events"
                        hide-actions
                        item-key="name"
                        expand
                >
                    <template slot="items" slot-scope="props">
                        <tr @click="props.expanded = !props.expanded">
                            <td class="text-xs-left">
                                <v-avatar>
                                    <img :src="props.item.image">
                                </v-avatar>
                                {{ props.item.name }}
                            </td>
                            <td class="text-xs-left">
                                <template v-if="props.item.inscription_type_id == 1">
                                    Grup
                                </template>
                                <template v-else>
                                    Individual
                                </template>
                            </td>
                            <td class="text-xs-left">{{ props.item.tickets }}</td>
                            <td class="text-xs-left">{{ props.item.assigned_tickets }}</td>
                            <td class="text-xs-left">{{ props.item.available_tickets }}</td>
                            <td class="text-xs-left">TODO</td>
                            <td class="text-xs-right">
                                <v-switch v-model="inscriptions[props.item.id]" @click.native.stop="return;" @change="toogleInscription(props.item)"></v-switch>
                            </td>
                        </tr>
                    </template>
                    <template slot="expand" slot-scope="props">
                        <v-card>
                            <v-card-text>
                                <template v-if="props.item.inscription_type_id == 1">
                                    <v-list two-line>
                                        <template v-for="(group, index) in props.item.groups">
                                            <v-list-tile avatar :key="group.title" @click="">
                                                <v-list-tile-avatar>
                                                    <template v-if="group.avatar">
                                                        <img :src="group.avatar">
                                                    </template>
                                                    <template v-else>
                                                        <img src="/img/groupPlaceholder.jpg">
                                                    </template>
                                                </v-list-tile-avatar>
                                                <v-list-tile-content>
                                                    <v-list-tile-title>{{group.name}}</v-list-tile-title>
                                                    <v-list-tile-sub-title>
                                                        Leader:
                                                        <template v-if="group.leader">{{group.leader.sn1}} {{group.leader.sn2}},{{group.leader.givenName}} ({{group.leader.name}})</template>
                                                        <template v-else>No leader assigned</template>
                                                        | Team members:
                                                        <template v-if="group.users">{{group.leader.sn1}} {{group.leader.sn2}},{{group.leader.givenName}} ({{group.leader.name}})</template>
                                                        <template v-else>No members assigned</template>
                                                    </v-list-tile-sub-title>
                                                </v-list-tile-content>
                                            </v-list-tile>
                                        </template>
                                    </v-list>
                                </template>
                                <template v-else>
                                    <v-list two-line>
                                        <template v-for="(user, index) in props.item.users">
                                            <v-list-tile avatar :key="user.title" @click="">
                                                <v-list-tile-avatar>
                                                    <img :src="gravatarURL(user.email)">
                                                </v-list-tile-avatar>
                                                <v-list-tile-content>
                                                    <v-list-tile-title>{{user.sn1}} {{user.sn2}} , {{user.givenName}} ({{user.name}})</v-list-tile-title>
                                                    <v-list-tile-sub-title v-html="user.email"></v-list-tile-sub-title>
                                                </v-list-tile-content>
                                            </v-list-tile>
                                        </template>
                                    </v-list>
                                </template>
                            </v-card-text>
                        </v-card>
                    </template>
                </v-data-table>
            </v-card-text>
        </v-card>
    </div>
</template>

<style>

</style>

<script>
  import InteractsWithGravatar from './mixins/interactsWithGravatar'
  import Group from './GroupComponent.vue'

  const GROUP = '1'

  export default {
    name: 'Events',
    components: { Group },
    mixins: [InteractsWithGravatar],
    data () {
      return {
        showInscribeToGroupEvent: false,
        currentEvent: null,
        inscriptions: this.populateInscriptions(),
        headers: [
          { text: 'Nom', align: 'left', value: 'name' },
          { text: 'Tipus', value: 'inscription_type_id' },
          { text: 'Places', value: 'tickets' },
          { text: 'Inscrits', value: 'assigned_tickets' },
          { text: 'Disponibles', value: 'available_tickets' },
          { text: 'Reglament', value: 'rules_link' },
          { text: 'Inscrit?', value: 'inscribed' }
        ]
      }
    },
    props: {
      events: {
        type: Array,
        required: true
      }
    },
    methods: {
      toogleInscription (event) {
        if (this.inscriptions[event.id]) {
          console.log('Register to event ' + event.name)
          this.registerToEvent(event)
        } else {
          console.log('Unregister to event ' + event.name)
          this.unregisterToEvent(event)
        }
      },
      registerToEvent (event) {
        if (event.inscription_type_id === GROUP) {
          this.showInscribeToGroupEvent = true
          this.currentEvent = event
        } else {
          console.log('register to individual event')
        }
      },
      unregisterToEvent (event) {
        if (event.inscription_type_id === GROUP) {
          console.log('unregister to group event')
        } else {
          console.log('unregister to individual event')
        }
      },
      populateInscriptions () {
        const inscriptions = {}

        this.events.forEach(event => {
          inscriptions[event.id] = event.inscribed
        })

        return inscriptions
      }
    }
  }
</script>
