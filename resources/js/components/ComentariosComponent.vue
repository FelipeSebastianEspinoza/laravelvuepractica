<template>
    <div>
        <div v-for="item in comentarios" :key="item.id">
            <b-card no-body style="max-width: 100rem;" img-top>
                <template v-slot:header>
                    <div>
                        <b-avatar
                            src="https://placekitten.com/300/300"
                            class="mr-2"
                        ></b-avatar>
                        Hello World
                        <!--    <b-card-sub-title class="mt-1 float-right">{{
                            item.updated_at
                        }}</b-card-sub-title> -->
                    </div>
                </template>

                <b-card-body>
                    <b-card-text>
                        <p v-if="item.updated_at">(Editado)</p>
                        {{ item.text }}
                    </b-card-text>
                </b-card-body>

                <b-card-footer>
                    <a href="#" class="card-link">Card link</a>
                    <a href="#" class="card-link">Another link</a>
                    <p class="float-right">creado el: 
                       {{ item.created_at  }}      </p>
                        
                </b-card-footer>
            </b-card>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            comentarios: [],
            comentario: { text: "" }
        };
    },
    created() {
        axios.get("/comentarios").then(res => {
            this.comentarios = res.data;
        });
    }
};
</script>
