import API from "./api.js";

const Todo = {
    async getAll() {
        return await API('/todo', { method: 'GET' })
    },

    async create(description) {
        return await API('/todo', {
            method: 'POST',
            body: JSON.stringify({ description, completed: false })
        })
    },

    async update(id, completed) {
        return await API(`/todo/${id}`, {
            method: 'PUT',
            body: JSON.stringify({ completed: completed })
        })
    },

    async delete(id) {
        return await API(`/todo/${id}`, {
            method: 'DELETE'
        })
    }
}

export default Todo