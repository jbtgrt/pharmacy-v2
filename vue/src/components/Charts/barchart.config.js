export const chartColors = {
  default: {
    primary: '#00D1B2',
    info: '#209CEE',
    danger: '#FF3860'
  }
}

const randomBarChartData = (n) => {
  const data = [];

  for (let i = 0; i < n; i++) {
    data.push(Math.round(Math.random() * 100)); // Adjust range as needed
  }

  return data;
}

const barDatasetObject = (color, points) => {
  return {
    label: `Dataset ${color}`, // Use color as part of the label
    backgroundColor: chartColors.default[color],
    borderColor: 'rgba(255, 255, 255, 1)', // Border color
    borderWidth: 1,
    data: randomBarChartData(points),
  };
}


export const sampleBarChartData = (datasetsCount = 3, pointsPerDataset = 9) => {
  const labels = Array.from({ length: pointsPerDataset }, (_, i) => `0${i + 1}`);

  const datasets = Array.from({ length: datasetsCount }, (_, i) => {
    const colorKeys = Object.keys(chartColors.default);
    const color = colorKeys[i % colorKeys.length]; // Cycle through available colors

    return barDatasetObject(color, pointsPerDataset);
  });

  return {
    labels,
    datasets,
  };
}


// Function to generate random client data for each month
const generateClientDataForMonths = (months, clientsPerMonth) => {
  const data = [];
  
  for (let i = 0; i < months; i++) {
    const clients = [];
    for (let j = 0; j < clientsPerMonth; j++) {
      clients.push(Math.round(Math.random() * 100)); // Generate client count data
    }
    data.push(clients);
  }
  
  return data;
}

export const sampleClientBarChartData = (months = 5, clientsPerMonth = 8) => {
  const labels = Array.from({ length: months }, (_, i) => `Month ${i + 1}`);
  const clientData = generateClientDataForMonths(months, clientsPerMonth);
  const datasets = clientData.map((data, index) => {
    const colorKeys = Object.keys(chartColors.default);
    const color = colorKeys[index % colorKeys.length];
    
    return {
      label: `Month ${index + 1}`,
      backgroundColor: chartColors.default[color],
      borderColor: 'rgba(255, 255, 255, 1)',
      borderWidth: 1,
      data: data,
    };
  });

  return {
    labels,
    datasets,
  };
}