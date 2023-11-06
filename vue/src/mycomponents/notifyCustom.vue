<NotificationBar v-if="notification.show" :color="notification.type" :icon="mdiCheckCircle" :outline="notificationsOutline">
  <b>{{notification.message}}</b>
</NotificationBar>