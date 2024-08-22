import fetch from 'node-fetch';
import * as fs from 'fs';
import * as unzipper from 'unzipper';
import * as path from 'path';

async function handleLangFolder() {
    if (!fs.existsSync('./src/lang')) {
        fs.mkdirSync('./src/lang', { recursive: true });
    }
}

handleLangFolder().then(() => {
    getData();
});

function getData() {
    fetch('http://localhost:2402/language-key/export?project_id=27&languages=["de_DE", "en_US"]&format=json', {
        method: 'POST',
    })
        .then((response) => response.json())
        .then((zipUrl) => {
            downloadAndExtractZip(zipUrl, './src/lang');
        })
        .catch((error) => console.log(error));
}

function downloadAndExtractZip(url, destFolder) {
    fetch(url)
        .then(res => {
            if (!res.ok) {
                throw new Error(`Failed to fetch ${url}: ${res.statusText}`);
            }
            const tempFolder = path.join(destFolder, 'temp_unzip');
            if (!fs.existsSync(tempFolder)) {
                fs.mkdirSync(tempFolder);
            }
            return res.body.pipe(unzipper.Extract({ path: tempFolder }))
                .promise()
                .then(() => tempFolder);
        })
        .then(tempFolder => {
            moveFilesFromSubfolder(tempFolder, destFolder);
        })
        .catch(err => console.log('Error downloading or extracting ZIP:', err));
}

function moveFilesFromSubfolder(srcFolder, destFolder) {
    fs.readdir(srcFolder, (err, folders) => {
        if (err) throw err;

        const subfolderPath = path.join(srcFolder, folders[0]);

        fs.readdir(subfolderPath, (err, files) => {
            if (err) throw err;

            files.forEach(file => {
                const srcPath = path.join(subfolderPath, file);
                const destPath = path.join(destFolder, file);

                fs.rename(srcPath, destPath, (err) => {
                    if (err) throw err;
                    console.log(`Moved file: ${file} to ${destFolder}`);
                });
            });

            fs.rmdir(srcFolder, { recursive: true }, (err) => {
                if (err) throw err;
                console.log(`Deleted temporary folder: ${srcFolder}`);
            });
        });
    });
}
