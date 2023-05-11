import { post } from "../api/api.mjs";

const login = async (target) => {
    console.log(target);
    const result = await post("login", new FormData(target));

    if (result.ok) {
        // load javascript file
        import("../pages/after-login.mjs");
    }
    console.log(result);
};

export default login;
