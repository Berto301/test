
import http from "../axios";

const UsersService = {
    async deleteById(id) {
        try {
            const response = await http.delete(`users/${id}`);
            return response.data;
        } catch (error) {
            throw new Error(`[UsersService] Delete by ID | ${error}`);
        }
    },
    async create(data) {
        try {
            const response = await http.post(`users`,data);
            return response.data;
        } catch (error) {
            throw new Error(`[UsersService] Create | ${error}`);
        }
    },
    async update(data) {
        try {
            const response = await http.patch(`users/${data.id}`,data);
            return response.data;
        } catch (error) {
            throw new Error(`[UsersService] Create | ${error}`);
        }
    }
}
export default UsersService

