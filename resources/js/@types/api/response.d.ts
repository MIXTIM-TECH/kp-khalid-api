declare namespace Api {
    interface Response {
        ok: boolean
        status: number
        statusText: string
        data: Record<string, any>
    }
}
