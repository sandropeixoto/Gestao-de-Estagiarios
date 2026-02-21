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
import path from 'path';

dotenv.config();

const app = express();
const port = process.env.PORT || 3000;

app.use(cors());
app.use(helmet());
app.use(morgan('dev'));
app.use(express.json());

// Serve static frontend files
app.use(express.static(path.join(__dirname, '../public')));

// Routes
app.use('/student', studentRoutes);
app.use('/supervisor', supervisorRoutes);
app.use('/contract', contractRoutes);
app.use('/institution', institutionRoutes);
app.use('/timesheet', timesheetRoutes);
app.use('/dashboard', dashboardRoutes);
app.use('/status', statusRoutes);

// Fallback for SPA routing (Express 5 compatible)
app.use((req, res, next) => {
    if (req.method === 'GET') {
        res.sendFile(path.join(__dirname, '../public/index.html'));
    } else {
        res.status(404).json({ error: 'Not found' });
    }
});

app.listen(port, () => {
    console.log(`Server is running on port ${port}`);
});
