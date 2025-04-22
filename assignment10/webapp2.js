const express = require('express');
const body_parser = require('body-parser');
const MongoClient = require('mongodb').MongoClient;
const path = require('path');
const app = express();
const PORT = process.env.PORT || 3000;

// Middleware as seen in https://zellwk.com/blog/crud-express-mongodb/. Will parse the data for us!
app.use(body_parser.urlencoded({ extended: true }));

// Our db connection string
// const connectionString = 'mongodb+srv://juanalvarado:RPCV4txMhi02sD1c@cluster0.qedn8qy.mongodb.net/?retryWrites=true&w=majority&appName=Cluster0'; // heroku version below
const connectionString = process.env.MONGO_URI;

// Alright lets establish the connection to MongoDB
let db, collection;
MongoClient.connect(connectionString)
        .then(client => {
                db = client.db('assignment10');
                collection = db.collection('places');
                app.listen(PORT, () => {
                        console.log(`Server is running on http://localhost:3000`);
                });
        })
        .catch(err => console.error('db connection error:', err));

// Alright, now lets route the information from our homepage found in index.html
app.get('/', (req, res) => {
        res.sendFile(path.join(__dirname, 'index.html'));
});

// Alright, now lets grab the info being sent over in our homepage and do the stuff!
app.post('/process', async (req, res) => {
        const user_input = req.body.query.trim();

        try {

                if (!isNaN(user_input.charAt(0))) {
                        // Case where we have a zipcode since they start with nums only
                        result = await collection.find({ zips: user_input }).toArray();
                } else {
                        // Case where place since can only be one of two
                        const regex = new RegExp(`^${user_input}$`, 'i'); // https://www.mongodb.com/docs/manual/reference/operator/query/regex/ + https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/RegExp--> NICE
                        const query = { place: regex };
                        result = await collection.find(query).toArray();
                }

                // Case where we didn't find the result
                if (result.length === 0) {
                        res.send(`<h2>No results found for "${user_input}"</h2><a href="/">Back</a>`);
                } else {
                        // Case where we hit something
                        console.log('Results:', result);
                        let html = `<h2>Results for "${user_input}"</h2><ul>`;
                        // Alirght lets now build out our list
                        result.forEach(doc => {
                                html += `<li><strong>${doc.place}</strong>: ${doc.zips.join(', ')}</li>`;
                        });
                        // Lets finish that bad boy up
                        html += `</ul><a href="/">Back</a>`;
                        //Did this work?
                        //console.log(html) // DEBUG
                        res.send(html);
                }
        } catch (err) {
                console.error(err);
                res.send(`<p>Error occurred: ${err.message}</p><a href="/">Back</a>`);
        }
});