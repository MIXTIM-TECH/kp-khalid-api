const BASE_API = "http://127.0.0.1:8000/api";

const getToken = () => localStorage.getItem("token_access");

export const get = (path) => {
    return new Promise((resolve) => {
        fetch(`${BASE_API}/${path}`)
            .then((res) => res.json())
            .then((res) => resolve(res));
    });
};

export const post = (path, body) => {
    return new Promise((resolve) => {
        fetch(`${BASE_API}/${path}`, {
            body,
            method: "POST",
            headers: {
                Authorization: `Bearer ${getToken()}`,
            },
        })
            .then((res) => res.json())
            .then((res) => resolve(res));
    });
};
