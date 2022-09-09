import axios from "axios";


export default {
    async getAllToDo(res){
        const data = await axios.get('/api/notes') ; //.then((item)=>{commit('setTodos',item); console.log(item); return item})
        return res.commit('setTodos', data.data.entities)
    },
    async delToDo({commit, state},id){
        const data = await axios.delete(`/api/notes/${id}`) ;
        return commit('deleteTodos', id)
    },
    // async getOneToDo({commit,state},slug){
    //     await axios.get(`/api/notes/${slug}/points`)
    //     return commit('oneToDo', slug)
    // }
}