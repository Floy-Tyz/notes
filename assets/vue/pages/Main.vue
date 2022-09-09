<template>
    <div id="main">
        <div id="text">
            <div id="vue">
                Vue<span id="first-time"> первый раз</span>
            </div>
            <div class=" flex flex-row space-x-10  ">
                <ToDoItem
                    v-for="item in entities"
                    :item="item"
                    :key="item.id"
                />
                <AddToDoItem/>
            </div>
        </div>
    </div>
</template>

<script>
import {mapActions, mapState} from "vuex";
import ToDoItem from "./components/ToDoItem";
import AddToDoItem from "./components/AddToDoItem";

export default {
    name: "MainComponent",
    components: {AddToDoItem, ToDoItem},
    computed: {

        // смешиваем результат mapState с внешним объектом
        ...mapState({
            entities: state => state.todos,
        }),
    },

    methods: {
        ...mapActions([
            'getAllToDo',
        ]),
        updateMessage(e) {
            this.$store.commit('updateMessage', e.target.value)
        }
    },
    mounted() {
        this.getAllToDo()
    }
}
</script>


<style scoped>

.click {
    background-color: aqua;
}

#listButtons {
    display: flex;
    flex-direction: row;

}

#listButtons button:first-child {
    background-color: #f25f5c;
    padding: 0.7rem 2rem 0.7rem 2rem;
    border: 0;
    border-radius: 2rem;
    margin-right: 1.5rem;
    margin-top: 1.5rem;
    font-weight: bold;
    color: white;
    font-size: 1rem;
}

#listButtons button {
    background-color: #3d3d3d;
    border: 0;
    padding: 0.7rem 2rem 0.7rem 2rem;
    border-radius: 2rem;
    margin-right: 1.5rem;
    margin-top: 1.5rem;
    font-weight: bold;
    color: white;
    font-size: 1rem;
}

#main {
    margin-top: 5rem;
    color: #d0d0d0;
    font-size: x-large;


}

#text {
    display: flex;
    flex-direction: column;
    align-items: start;
    margin-top: 0.5rem;
    margin-left: 10rem;
}

#vue {
    font-size: 4rem;
    font-weight: bolder;
    color: #FFE066;
}

#first-time {
    /*font-size: 4rem;*/
    /*font-weight: bolder;*/
    /*margin-bottom: 0.5rem;*/
    color: white;

}

#buttons {
    font-weight: normal;
}
</style>