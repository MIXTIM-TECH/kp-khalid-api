import { el } from "./global"
import { Notification } from "./notifications"

const errorMessage = (text: string) => {
    Notification.fire({
        icon: "error",
        text
    })
}

const validationErrors = (errors: Record<string, string[]>) => {
    for (const error in errors) {
        el(`[name="${error}"]`)?.classList.add("is-invalid")
    }
}

const handleErrors = (response: Api.Response) => {
    if ("message" in response.data) {
        errorMessage(response.data.message)
    } else if ("errors" in response.data) {
        validationErrors(response.data.errors)
    } else {
        console.error({ "error not recognized": response })
    }
}

export default handleErrors
