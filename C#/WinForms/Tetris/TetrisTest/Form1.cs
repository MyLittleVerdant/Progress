using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace Tetris
{
    public partial class Form1 : Form
    {
    
        Shape currentShape;
        int Tick ;
        int linesRemoved;
        int Score ;
        const int width = 15, height = 25, size = 20;
        int[,] map = new int[height,width];
        public Form1()
        {
            InitializeComponent();
           
            Init();
        }
        
        public void Init()
        {

            
            Score = 0; 
            linesRemoved = 0;
            currentShape = new Shape(3, 0);
            Tick = 300;

            TickTimer.Interval = Tick;
            TickTimer.Tick += new EventHandler(update);
            TickTimer.Start();


            Invalidate();
        }

        private void Form1_KeyDown(object sender, KeyEventArgs e)
        {
            switch (e.KeyCode)
            {
                case Keys.W:
                    if (!IsIntersects())
                    {
                        ResetArea();
                        currentShape.RotateShape();
                        Merge();
                        Invalidate();
                    }
                    break;
                case Keys.S:
                    TickTimer.Interval = 50; break;

                case Keys.D:
                    if (!CollideHor(1))
                    {
                        ResetArea();
                        currentShape.MoveRight();
                        Merge();
                        Invalidate();
                    }
                    break;
                case Keys.A:
                    if (!CollideHor(-1))
                    {
                        ResetArea();
                        currentShape.MoveLeft();
                        Merge();
                        Invalidate();
                    }
                    break;
            }
        }



        public void ShowNextShape(Graphics e)
        {
            for (int i = 0; i < currentShape.sizeNextMatrix; i++)
            {
                for (int j = 0; j < currentShape.sizeNextMatrix; j++)
                {
                    if (currentShape.nextMatrix[i, j] == 1)
                    {
                        e.FillRectangle(Brushes.Green, new Rectangle(420 + j * (size) + 1, 110 + i * (size) + 1, size - 1, size - 1));
                    }
                }
            }
        }

        private void Form1_KeyUp(object sender, KeyEventArgs e)
        {
            TickTimer.Interval = Tick;
        }
        private void update(object sender, EventArgs e)
        {
            
            ResetArea();
            if (!Collide())
            {
                currentShape.MoveDown();
            }
            else
            {
                Merge();
                SliceMap();

                currentShape.ResetShape(3, 0);
                if (Collide())
                {
                    for (int i = 0; i < height; i++)
                    {
                        for (int j = 0; j < width; j++)
                        {
                            map[i, j] = 0;
                        }
                    }
                    TickTimer.Tick -= new EventHandler(update);
                    TickTimer.Stop();
                    label3.Visible = true;
                   

                }
            }
            Merge();
            Invalidate();
        }

        public void SliceMap()
        {
            int count = 0;
           
            for (int i = 0; i < height; i++)
            {
                count = 0;
                for (int j = 0; j < width; j++)
                {
                    if (map[i, j] != 0)
                        count++;
                }
                if (count == width)
                {
                    linesRemoved++;
                    Score += 10 * linesRemoved + 300 - Tick;
                    for (int k = i; k >= 1; k--)
                    {
                        for (int o = 0; o < width; o++)
                        {
                            map[k, o] = map[k - 1, o];
                        }
                    }
                    if (Tick > 60)
                        Tick = Tick - 10;
                }
            }
            
            label2.Text = "Score: " + Score;
            
            label1.Text = "Lines: " + linesRemoved;
            
        }

        public bool IsIntersects()
        {
            for (int i = currentShape.y; i < currentShape.y + currentShape.sizeMatrix; i++)
            {
                for (int j = currentShape.x; j < currentShape.x + currentShape.sizeMatrix; j++)
                {
                    if (j >= 0 && j <= width-1)
                    {
                        if (map[i, j] != 0 && currentShape.matrix[i - currentShape.y, j - currentShape.x] == 0)
                            return true;
                    }
                }
            }
            return false;
        }

        

        
        
        

        public void Merge()
        {
            for (int i = currentShape.y; i < currentShape.y + currentShape.sizeMatrix; i++)
            {
                for (int j = currentShape.x; j < currentShape.x + currentShape.sizeMatrix; j++)
                {
                    if (currentShape.matrix[i - currentShape.y, j - currentShape.x] != 0)
                        map[i, j] = currentShape.matrix[i - currentShape.y, j - currentShape.x];
                }
            }
        }

        public bool Collide()
        {
            for (int i = currentShape.y + currentShape.sizeMatrix - 1; i >= currentShape.y; i--)
            {
                for (int j = currentShape.x; j < currentShape.x + currentShape.sizeMatrix; j++)
                {
                    if (currentShape.matrix[i - currentShape.y, j - currentShape.x] != 0)
                    {
                        if (i + 1 == height)
                            return true;
                        if (map[i + 1, j] != 0)
                        {
                            return true;
                        }
                    }
                }
            }
            return false;
        }

        public bool CollideHor(int dir)
        {
            for (int i = currentShape.y; i < currentShape.y + currentShape.sizeMatrix; i++)
            {
                for (int j = currentShape.x; j < currentShape.x + currentShape.sizeMatrix; j++)
                {
                    if (currentShape.matrix[i - currentShape.y, j - currentShape.x] != 0)
                    {
                        if (j + 1 * dir > width-1 || j + 1 * dir < 0)
                            return true;

                        if (map[i, j + 1 * dir] != 0)
                        {
                            if (j - currentShape.x + 1 * dir >= currentShape.sizeMatrix || j - currentShape.x + 1 * dir < 0)
                            {
                                return true;
                            }
                            if (currentShape.matrix[i - currentShape.y, j - currentShape.x + 1 * dir] == 0)
                                return true;
                        }
                    }
                }
            }
            return false;
        }

        public void ResetArea()
        {
            for (int i = currentShape.y; i < currentShape.y + currentShape.sizeMatrix; i++)
            {
                for (int j = currentShape.x; j < currentShape.x + currentShape.sizeMatrix; j++)
                {
                    if (i >= 0 && j >= 0 && i < height && j < width)
                    {
                        if (currentShape.matrix[i - currentShape.y, j - currentShape.x] != 0)
                        {
                            map[i, j] = 0;
                        }
                    }
                }
            }
        }
        public void DrawFigure(Graphics g)
        {
            //g.FillRectangle(Brushes.Black, new Rectangle(10, 10, size * (width + 1) + 1, size * (height + 3) + 1));
            for (int i = 0; i < height ; i++)
            {
                for (int j = 0; j < width; j++)
                {
                    if (map[i, j] == 1)
                    {
                        g.FillRectangle(Brushes.Green, new Rectangle(50 + j * size + 1, 50 + i * size + 1, size - 1, size - 1));
                    }
             

                }
            }
        }

       

        public void DrawGrid(Graphics g)
        {
            for (int i = 0; i <= height; i++)
            {
                g.DrawLine(Pens.Black, new Point(50, 50 + i * size), new Point(50 + width * size, 50 + i * size));
            }
            for (int i = 0; i <= width; i++)
            {
                g.DrawLine(Pens.Black, new Point(50 + i * size, 50), new Point(50 + i * size, 50 + height * size));
            }
            g.DrawRectangle(Pens.Black, new Rectangle(400, 90, 100, 100));
        }
        private void OnPaint(object sender, PaintEventArgs e)
        {
            DrawGrid(e.Graphics);
            DrawFigure(e.Graphics);
            ShowNextShape(e.Graphics);
        }
    }
    
}
