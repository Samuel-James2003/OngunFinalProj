const fs = require('fs');
const DOMParser = require('xmldom').DOMParser;

function parseXMLFile(filePath) {
  const xmlString = fs.readFileSync(filePath, 'utf8');
  const parser = new DOMParser();
  const xmlDoc = parser.parseFromString(xmlString);

  // Extract data between specified tags
  const dateOfBirth = xmlDoc.querySelector('dateofbirth').textContent;
  const name = xmlDoc.querySelector('name').textContent;
  const firstName = xmlDoc.querySelector('firstname').textContent;
  const middleNames = xmlDoc.querySelector('middlenames').textContent;
  const nationality = xmlDoc.querySelector('nationality').textContent;
  const streetAndNumber = xmlDoc.querySelector('streetandnumber').textContent;
  const zip = xmlDoc.querySelector('zip').textContent;
  const municipality = xmlDoc.querySelector('municipality').textContent;

  const data = {
    dateOfBirth,
    name,
    firstName,
    middleNames,
    nationality,
    streetAndNumber,
    zip,
    municipality,
  };

  return data;
}