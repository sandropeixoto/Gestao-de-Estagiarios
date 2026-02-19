import express from 'express';
import cors from 'cors';
import helmet from 'helmet';
import morgan from 'morgan';
import dotenv from 'dotenv';
import studentRoutes from './routes/studentRoutes';
import supervisorRoutes from './routes/supervisorRoutes';
import contractRoutes from './routes/contractRoutes';
import institutionRoutes from './routes/institutionRoutes';
import timesheetRoutes from './routes/timesheetRoutes';
import dashboardRoutes from './routes/dashboardRoutes';
import statusRoutes from './routes/statusRoutes';

dotenv.config();

const app = express();
const port = process.env.PORT || 3000;

app.use(cors());
app.use(helmet());
app.use(morgan('dev'));
app.use(express.json());

// Routes
app.use('/student', studentRoutes);
app.use('/supervisor', supervisorRoutes);
app.use('/contract', contractRoutes);
app.use('/institution', institutionRoutes);
app.use('/timesheet', timesheetRoutes);
app.use('/dashboard', dashboardRoutes);
app.use('/status', statusRoutes);

app.get('/', (req, res) => {
    res.send('Gestao de Estagiarios API is running');
});

app.listen(port, () => {
    console.log(`Server is running on port ${port}`);
});
