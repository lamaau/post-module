<template>
  <v-inertable
    :allow-filter="false"
    :filters="inertable.filters"
    :data="inertable.data"
    :columns="inertable.columns"
  >
    <template #attributes>
      <button
        @click.prevent="create"
        type="button"
        class="btn-purple btn-ring-purple"
      >
        New Category
      </button>
    </template>
    <template #description="{ item: { description } }">
      <v-nullable :value="description" />
    </template>
    <template #created_at="{ item: { created_at } }">
      <span>{{ $helper.formatDate(created_at) }}</span>
    </template>
    <template #action="{ item: { id } }">
      <div class="flex space-x-2">
        <button
          @click.prevent="edit(id)"
          class="
            rounded-md
            bg-yellow-400
            p-2
            focus:outline-none
            focus:ring-2
            focus:ring-yellow-400
            focus:ring-offset-2
          "
        >
          <v-icon name="PencilIcon" type="solid" class="h-3 w-3 text-white" />
        </button>
        <button
          @click.prevent="destroy(id)"
          type="button"
          class="
            rounded-md
            bg-red-500
            p-2
            focus:outline-none
            focus:ring-2
            focus:ring-red-500
            focus:ring-offset-2
          "
        >
          <v-icon name="TrashIcon" type="solid" class="h-3 w-3 text-white" />
        </button>
      </div>
    </template>
  </v-inertable>
</template>
<script>
export default {
  props: {
    inertable: Object,
  },
  computed: {
    category() {
      //
    },
  },
  methods: {
    create() {
      this.$modal.open({
        title: "New Category",
        component: require("./create.vue").default,
      });
    },
    async edit(id) {
      await this.$store.dispatch("category/setCategory", id);

      this.$modal.open({
        title: "Update Category",
        category: this.category,
        component: require("./edit.vue").default,
      });
    },
    destroy(id) {
      this.$modal.destroy({
        title: "Are you sure?",
        message: "This will permanently delete the category from database",
        onCancel: () => this.$modal.close(),
        onAccept: () => {
          this.$inertia.delete(
            this.$route("dashboard.post.category.destroy", { id }),
            {
              onSuccess: () => {
                this.$modal.close();
              },
            },
          );
        },
      });
    },
  },
};
</script>
