let UUID = 0;

const getID = () => {
    UUID++;
    return UUID;
};

export default getID;