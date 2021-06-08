using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace Banker_s_Algorithm
{
    public partial class Form1 : Form
    {
        public Form1()
        {
            InitializeComponent();
        }


        Random rnd = new Random();
        static int RandomNum;

        int Available;
        bool start = false;
        int sum = 0;
        bool choose = false;
        int done = 0;
        string sequence;

        List<Processes> List = new List<Processes>();

        private void button1_Click(object sender, EventArgs e)//Generate
        {
            if (!choose)
            {
                start = true;
                Sabbatarian();
                
                Available = 10;
                label2.Text += " 10";
                FillList();
                FillTable();
                CheckEmptyNeed();
                CheckAvailableError();
            }
        }


        public void FillList()
        {

            for (int i = 0; i < 4; i++)//fill the table
            {
                Processes tmp = new Processes();
                tmp.name = (char)(65 + i);
                RandomNum = rnd.Next(1, 10);
                tmp.max = RandomNum;
                RandomNum = rnd.Next(1, 4);
                tmp.has = RandomNum;

                List.Add(tmp);
                tmp = null;
            }
        }

        public void FillTable()
        {
            dataGridView1.Rows.Add(3);
            for (int i = 0; i < 4; i++)
            {
                
                dataGridView1.Rows[i].Cells[0].Value = List.ElementAt(i).name;
                dataGridView1.Rows[i].Cells[1].Value = List.ElementAt(i).has;
                dataGridView1.Rows[i].Cells[2].Value = List.ElementAt(i).max;
                dataGridView1.Rows[i].Cells[3].Value = List.ElementAt(i).max - List.ElementAt(i).has;
                List.ElementAt(i).need =(int)dataGridView1.Rows[i].Cells[3].Value;

            }
            SumAll();
            Available -= sum;
            sum = 0;
            label2.Text = "Available: " + Available;
        }

        

        public int CheckEmptyNeed()//провека некорректных значений need
        {
            for (int i = 0; i < 4; i++)
            {
                if (List.ElementAt(i).need < 1)
                {
                    Sabbatarian();
                    Available = 10;
                    label2.Text += " 10";
                    FillList();
                    FillTable();
                    CheckEmptyNeed();
                    CheckAvailableError();
                    return 2;
                }
                
            }
            return 1;
        }

        public int CheckAvailableError()//провека нехватки доступных ресурсов
        {
            bool flag = false;
            for (int i = 0; i < 4; i++)
            {
                if(Available>= List.ElementAt(i).need)
                {
                    flag = true;
                    return 1;
                }
            }

            if(!flag)
            {
                Sabbatarian();
                Available = 10;
                
                FillList();
                FillTable();
                CheckEmptyNeed();
                CheckAvailableError();
            }
            return 0;
        }

        public void Sabbatarian()//субботник
        {
            List.Clear();
            dataGridView1.Rows.Clear();

        }

        public void SumAll()//сумма выдачей
        {
            for (int i = 0; i < 4; i++)
            {
                sum += List.ElementAt(i).has;
            }
        }

        private void button2_Click(object sender, EventArgs e)//Next
        {
            
            if (start)
            {
                choose = true;
                Nullify();
                Next();
                FillDoneCell();
                FinishHim();
            }
            
        }

        public int Nullify()
        {
            for (int i = 0; i < 4; i++)
            {
                if (List.ElementAt(i).done == "true" && List.ElementAt(i).max != 0)
                {
                    Available += List.ElementAt(i).has;
                    label2.Text = "Available: " + Available;
                    done++;

                    List.ElementAt(i).has = 0;
                    dataGridView1.Rows[i].Cells[1].Value = List.ElementAt(i).has;
                    List.ElementAt(i).max = 0;
                    dataGridView1.Rows[i].Cells[2].Value = List.ElementAt(i).max;
                    List.ElementAt(i).need = 0;
                    dataGridView1.Rows[i].Cells[3].Value = List.ElementAt(i).need;
                    return 1;
                }
            }
            return 0;
        }
        public int Next()
        {
            for (int i = 0; i < 4; i++)
            {
                if (Available >= List.ElementAt(i).need && List.ElementAt(i).done!= "true")
                {
                    List.ElementAt(i).done = "true";
                    sequence +="  "+ List.ElementAt(i).name;
                    return 1;
                }
                else if(Available < List.ElementAt(i).need)
                    List.ElementAt(i).done = "false";
            }
            return 0;
        }
        public void FillDoneCell()
        {
            for (int i = 0; i < 4; i++)
            {
                if (List.ElementAt(i).done == "true")
                {
                    dataGridView1.Rows[i].Cells[4].Value = "T";
                    dataGridView1.Rows[i].Cells[4].Style.BackColor = Color.Green;
                    
                }
                else if(List.ElementAt(i).done == "false")
                {
                    dataGridView1.Rows[i].Cells[4].Value = "F";
                    dataGridView1.Rows[i].Cells[4].Style.BackColor = Color.Red;
                }

            }
            
        }

        public void FinishHim()
        {
            if (done == 4)
            { 
                label3.Text += sequence;
                start = false;
            }
        }

    }
}
