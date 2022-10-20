
class FailedFetchError extends Error {
    constructor(...params) {
        super(...params);

        // Maintains proper stack trace for where our error was thrown (only available on V8)
        if (Error.captureStackTrace) {
            Error.captureStackTrace(this, FailedFetchError);
        }

        this.name = 'FailedFetchError';
        const responseObj = params.find(param => 'response' in param);
        this.response = 'response' in responseObj ? responseObj.response : {};
    }
}

// const csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
const request = async (url, data, method = 'get') => {
    try {
        const fetchRequest = await fetch(url, {
            body: JSON.stringify(data),
            method,
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                credentials: 'same-origin',
                'X-CSRF-Token': document.head.querySelector("[name~=csrf-token][content]").content
            }
        });
        if (!fetchRequest.ok) { throw new FailedFetchError({response: fetchRequest}); }

        const fetchJson = await fetchRequest.json();

        if (!fetchJson.status)
            throw new Error(fetchJson.message);

        return Promise.resolve(fetchJson);
    } catch ( error) {
        if (error instanceof FailedFetchError) {
            const jsonResponse = await error.response.json();
            if (jsonResponse) return Promise.reject({ message: jsonResponse.message});

            const message = await error.response.text();
            if (message) return Promise.reject({ message });
        }

        return Promise.reject({message: error.message});
    }
};
