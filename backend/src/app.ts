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
import fs from 'fs';

dotenv.config();

const app = express();
const port = process.env.PORT || 3000;

app.use(cors());
app.use(helmet());
app.use(morgan('dev'));
app.use(express.json());

// Serve static frontend files
app.use(express.static(path.join(__dirname, '../public')));

// API Routes Namespace
const apiRouter = express.Router();
apiRouter.use('/student', studentRoutes);
apiRouter.use('/supervisor', supervisorRoutes);
apiRouter.use('/contract', contractRoutes);
apiRouter.use('/institution', institutionRoutes);
apiRouter.use('/timesheet', timesheetRoutes);
apiRouter.use('/dashboard', dashboardRoutes);
apiRouter.use('/status', statusRoutes);

app.use('/api', apiRouter);

// Fallback for SPA routing (Express 5 compatible)
app.use((req, res, next) => {
    if (req.method === 'GET' && !req.path.startsWith('/api')) {
        const indexPath = path.join(__dirname, '../public/index.html');
        if (fs.existsSync(indexPath)) {
            return res.sendFile(indexPath);
        }
    }
    res.status(404).json({ error: 'Not found' });
});

app.listen(port, () => {
    console.log(`Server is running on port ${port}`);
});
