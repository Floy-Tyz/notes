import axios from "axios";
import getters from "./getters";


export default {
    async getAllToDo(res){
        const data = await axios.get('/api/notes') ; //.then((item)=>{commit('setTodos',item); console.log(item); return item})
        return res.commit('setTodos', data.data.entities)
    },
    async getTaskOfToDo({commit},id){
        let {data} = await axios.get(`/api/notes/${id}/points`) ;
        console.log(data.entities)
        // getters.allTaskOfToDo(data.entities)
        return commit('setTasks',data.entities)
    },
    async delToDo({commit, state},id){
        const data = await axios.delete(`/api/notes/${id}/${id}`) ;
        return commit('deleteTodos', id)
    },
    async addTask({commit,state}, {text, todoId}){
        console.log(text, todoId)
        let payload = {id:state.todos.find(x=>x.id===todoId).task?0:state.todos.find(x=>x.id===todoId).task.length, text:text, todoId:todoId}
        await axios.post(`/api/points/${id}`)
        return commit('createTask', payload)
    }
    // async getOneToDo({commit,state},slug){
    //     await axios.get(`/api/notes/${slug}/points`)
    //     return commit('oneToDo', slug)
    // }
                                        }