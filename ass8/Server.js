const express = require('express');
const app = express();

//Needed to read JSON data from POST body
app.use(express.json());// parses incoming JSON requests and puts the parsed data in req.body

let arr = [
  { id: 1, name: 'abc' },
  { id: 2, name: 'xyz' },
  { id: 200, name: 'pqr' }
];

// Default route
app.get('/', (req, res) => {
  res.send('hello world');
});

// Get all students
app.get('/student', (req, res) => {
  res.json(arr); 9
});


// get student by id 
app.get('/students', (req, res) => {
  let temp = req.query.id; //query object//now using body instead of query
  let obj = arr.find(x => x.id == temp);

  if (obj) {
    res.json(obj);
  } else {
    res.send('no record found');
  }
});


//post: http://localhost:3000/students and also add json raw data in body
app.post('/createstudent', (req, res) => {
  let newStudent = req.body;
  arr.push(newStudent);
  res.json(arr);
});

app.put('/updatestudent', (req, res) => {
  let temp = req.query.id;
  let obj = arr.find(x => x.id == temp);
  res.send(obj);
  if (obj) {
    obj.name = req.body.name;
    res.json(arr);
  }
});


// delete student 
app.delete('/students/:id',(req,res)=>{
    let temp=req.params.id;
    let index=arr.findIndex(x=>x.id==temp);
    if(index!=-1)
    {
        arr.splice(index,1);
        res.json(arr);
    }
    else{
        res.send('no record found');
    }
});


// Start server,()=>{} excuted only once when server is started
app.listen(3000, () => {
  console.log('server started at port 3000');
});