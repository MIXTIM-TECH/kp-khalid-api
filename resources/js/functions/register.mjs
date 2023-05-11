import { post } from "../api/api.mjs";

const register = async (target) => {
    const result = await post("register", new FormData(target));
    console.log(result);
};

export default register;
