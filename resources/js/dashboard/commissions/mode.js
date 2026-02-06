let mode = 'create';

const setMode = (m) => {
    mode = m;
}

const getMode = () => {
    return mode;
}

const getCommissionDetails = async (commissionId) => {
    return axios.get(`/commission/${commissionId}/edit`);
}

export {setMode, getMode, getCommissionDetails};
