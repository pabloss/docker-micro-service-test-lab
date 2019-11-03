import * as axios from 'axios';

const BASE_URL = 'http://service-test-lab-new.local';

function upload(formData) {
    const url = `${BASE_URL}/upload`;
    return axios.post(url, formData)
    // get data
        .then(x => x.data)
        ;
}

export { upload }
