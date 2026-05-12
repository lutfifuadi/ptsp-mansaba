const fs = require('fs');
const content = fs.readFileSync('D:/Project/Aplikasi PTSP/resources/assets/vendor/fonts/iconify/iconify.css', 'utf8');
const lines = content.split('\n');

lines.forEach((line, index) => {
    let doubleQuotes = 0;
    let singleQuotes = 0;
    for (let i = 0; i < line.length; i++) {
        if (line[i] === '"') doubleQuotes++;
        if (line[i] === "'") singleQuotes++;
    }
    if (doubleQuotes % 2 !== 0) {
        console.log(`Line ${index + 1} has odd number of double quotes: ${line}`);
    }
    // single quotes might be used inside double quotes, so we don't check parity of single quotes here
});
