//Lets first setup everything we will need to make webapp1 happen
const fs = require('fs'); 
const readline = require('readline');
const MongoClient = require('mongodb').MongoClient
const connectionString = 'mongodb+srv://juanalvarado:0nrBwY2mFhM0Qtat@cluster0.qedn8qy.mongodb.net/?retryWrites=true&w=majority&appName=Cluster0' //Got this from Atlas
const locations = {}; // We will use this to construct our entires

// We make it async as shown in lecture 
async function run() {
        let client;
        try {
                //Alright lets now interact with MongoDB and parse file 
                client = await MongoClient.connect(connectionString); // This ,connect() returns a promise. Await forces us to wait for resolution!
                const db = client.db('assignment10'); //db will allow us to interact with Mongodb!

                // We establish the places collection that we will write to
                const collection = db.collection('places');
                
                // Alright, now lets go ahead and parse through the zips.csv
                const file_stream = fs.createReadStream('zips.csv');
                const curr_line = readline.createInterface({ input: file_stream });
                
                //For each line we read, parse out the elements and add it to our locations array
                for await (const line of curr_line) {
                        
                        const [place, zip] = line.trim().split(',');
    
                        if (!locations[place]) {
                                locations[place] = [zip];
                                console.log(`Added new place: ${place} with zip ${zip}`);
                        } else if (!locations[place].includes(zip)) {
                                locations[place].push(zip);
                                console.log(`Updated ${place} with zip ${zip}`);
                        }
                }
    
                // Okay now lets convert the the locations in an object we can insert into DB.
                const locations_array = Object.entries(locations).map(([place, zips]) => ({
                        place,
                        zips
                }));
    
                // Lets sanitize what is in our DB first so that entries get added every time.
                await collection.deleteMany({});
                await collection.insertMany(locations_array);
                console.log('Data inserted into MongoDB');
    
        } catch (err) {
            console.error('Error:', err);
        } finally {
                if (client) {
                        await client.close();
                        console.log('Disconnected from MongoDB');
                }
        }
}
    
run();
