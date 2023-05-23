import handleErrors from "./functions/handleErrors"

const handleFetch = (endpoint: string, init?: RequestInit) => {
    return new Promise((resolve, reject) => {
        fetch(endpoint, init)
            .then((res) => {
                return {
                    ok: res.ok,
                    data: res.json(),
                    status: res.status,
                    statusText: res.statusText
                } as Api.Response
            })
            .then((res) => (res.ok ? resolve(res) : reject(res)))
    })
}

const headers = (headers?: HeadersInit): HeadersInit => {
    return {
        Authorization: `Bearer ${localStorage.getItem("token_access")}`,
        ...headers
    }
}

export const get = async (endpoint: string) => {
    try {
        const response = await handleFetch(endpoint, {
            method: "GET",
            headers: headers()
        })
        return response
    } catch (e: any) {
        return handleErrors(e)
    }
}
export const post = async (endpoint: string, body: HTMLFormElement) => {
    try {
        const response = await handleFetch(endpoint, {
            method: "POST",
            body: new FormData(body),
            headers: headers()
        })
        return response
    } catch (e: any) {
        return handleErrors(e)
    }
}
export const put = async (endpoint: string, body: HTMLFormElement) => {
    try {
        const response = await handleFetch(endpoint, {
            method: "PUT",
            body: JSON.stringify(Object.fromEntries(new FormData(body))),
            headers: headers({
                "Content-Type": "application/json"
            })
        })
        return response
    } catch (e: any) {
        return handleErrors(e)
    }
}
export const destroy = async (endpoint: string) => {
    try {
        const response = await handleFetch(endpoint, {
            method: "DELETE",
            headers: headers()
        })
        return response
    } catch (e: any) {
        return handleErrors(e)
    }
}
