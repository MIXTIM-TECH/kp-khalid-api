import { el } from "../functions/querySelector.mjs";

const onSubmit = (elementSelector = "", functionName) => {
    el(elementSelector)?.addEventListener("submit", (evt) => {
        evt.preventDefault();
        const fn = import(`../functions/${functionName}.mjs`);
        fn.then((value) => {
            value.default(evt.target);
        });
    });
};

onSubmit("#login-form", "login");
onSubmit("#register-form", "register");
