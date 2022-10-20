const processFormInputs = serializedData => {
    const processRepeatedValues = serializedData.filter(data => data.name.includes('['));

    const processedRepeatedValuesArray = [],
        valuesObject = {};

    processRepeatedValues.forEach(value => {
        const repeatedVal = value.name,
            regexForName = /[a-zA-Z_]/gm,
            regexForIndex = /[0-9]/g,
            name = repeatedVal.match(regexForName).join(''),
            index = parseInt(repeatedVal.match(regexForIndex).join('')),
            newValuesObject = {
                ...valuesObject,
                name,
                value: value.value
            };
        processedRepeatedValuesArray.push(newValuesObject);
    });

    const mergeArrays = serializedData
        .filter(data => !data.name.includes('['))
        .concat(processedRepeatedValuesArray);

    return mergeArrays
        .map(data => ({[data.name]: data.value}))
        .reduce((accumulator, current) => {
                const currentVal = Object.values(current),
                    currentKey = Object.keys(current),
                    previousVal = accumulator[currentKey[0]];

                let currentData = current;

                if (currentKey[0] in accumulator)
                    currentData[currentKey[0]] = [
                        previousVal,
                        currentVal[0]
                    ];

                return {
                    ...accumulator,
                    ...currentData,
                }
            }
        );
};
