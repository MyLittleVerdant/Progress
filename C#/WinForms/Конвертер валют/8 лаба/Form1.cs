using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace _8
{

    public partial class Form1 : Form
    {
        public Form1()
        {
            InitializeComponent();
        }
        double b;
        private void Form1_Load(object sender, EventArgs e)
        {

        }

        private void button1_Click(object sender, EventArgs e)
        {
            //usd
            if (radioButton1.Checked)
            {
                if (checkBox1.Checked)
                {
                    checkBox2.Checked = false;
                    int k = Convert.ToInt32(numericUpDown1.Value);
                    double b = k * double.Parse(textBox1.Text);
                    label4.Text += "Покупка " + k.ToString() + " USD = " + b.ToString() + " RUB \n";

                }

                if (checkBox2.Checked)
                {
                    int k = Convert.ToInt32(numericUpDown1.Value);
                    double b = k * double.Parse(textBox2.Text);
                    label4.Text += "Продажа " + k.ToString() + " USD = " + b.ToString() + " RUB\n";
                }
                label4.Text += "\n\n";
            }
            //eur
            if (radioButton2.Checked)
            {
                if (checkBox1.Checked)
                {
                    int k = Convert.ToInt32(numericUpDown1.Value);
                    double b = k * double.Parse(textBox3.Text);
                    label4.Text += "Покупка " + k.ToString() + " EUR = " + b.ToString() + " RUB \n";
                }

                if (checkBox2.Checked)
                {
                    int k = Convert.ToInt32(numericUpDown1.Value);
                    double b = k * double.Parse(textBox4.Text);
                    label4.Text += "Продажа " + k.ToString() + " EUR = " + b.ToString() + " RUB\n";
                }

                label4.Text += "\n\n";
            }
            //cny
            if (radioButton3.Checked)
            {
                if (checkBox1.Checked)
                {
                    int k = Convert.ToInt32(numericUpDown1.Value);
                    double b = k * double.Parse(textBox5.Text);
                    label4.Text += "Покупка " + k.ToString() + " CNY = " + b.ToString() + " RUB \n";
                }

                if (checkBox2.Checked)
                {
                    int k = Convert.ToInt32(numericUpDown1.Value);
                    double b = k * double.Parse(textBox6.Text);
                    label4.Text += "Продажа " + k.ToString() + " CNY = " + b.ToString() + " RUB\n";
                }
                label4.Text += "\n\n";
            }
            //UAH
            if (radioButton4.Checked)
            {
                if (checkBox1.Checked)
                {
                    int k = Convert.ToInt32(numericUpDown1.Value);
                    double b = k * double.Parse(textBox7.Text);
                    label4.Text += "Покупка " + k.ToString() + " UAH = " + b.ToString() + " RUB \n";
                }

                if (checkBox2.Checked)
                {
                    int k = Convert.ToInt32(numericUpDown1.Value);
                    double b = k * double.Parse(textBox8.Text);
                    label4.Text += "Продажа " + k.ToString() + " UAH = " + b.ToString() + " RUB\n";
                }
                label4.Text += "\n\n";
            }


        }

        private void button2_Click(object sender, EventArgs e)
        {
            label4.Text = "";
        }

        private void TextBox1_KeyPress(object sender, KeyPressEventArgs e)
        {
            
            if (!Char.IsDigit(e.KeyChar) && e.KeyChar != 8 && e.KeyChar != 44) // цифры, клавиша BackSpace и запятая
            {
                e.Handled = true;
            }
        }

        private void TextBox2_KeyPress(object sender, KeyPressEventArgs e)
        {
            if (!Char.IsDigit(e.KeyChar) && e.KeyChar != 8 && e.KeyChar != 44) // цифры, клавиша BackSpace и запятая
            {
                e.Handled = true;
            }
        }

        private void TextBox5_KeyPress(object sender, KeyPressEventArgs e)
        {
            if (!Char.IsDigit(e.KeyChar) && e.KeyChar != 8 && e.KeyChar != 44) // цифры, клавиша BackSpace и запятая
            {
                e.Handled = true;
            }
        }

        private void TextBox6_KeyPress(object sender, KeyPressEventArgs e)
        {
            if (!Char.IsDigit(e.KeyChar) && e.KeyChar != 8 && e.KeyChar != 44) // цифры, клавиша BackSpace и запятая
            {
                e.Handled = true;
            }
        }

        private void TextBox3_KeyPress(object sender, KeyPressEventArgs e)
        {
            if (!Char.IsDigit(e.KeyChar) && e.KeyChar != 8 && e.KeyChar != 44) // цифры, клавиша BackSpace и запятая
            {
                e.Handled = true;
            }
        }

        private void TextBox4_KeyPress(object sender, KeyPressEventArgs e)
        {
            if (!Char.IsDigit(e.KeyChar) && e.KeyChar != 8 && e.KeyChar != 44) // цифры, клавиша BackSpace и запятая
            {
                e.Handled = true;
            }
        }

        private void TextBox7_KeyPress(object sender, KeyPressEventArgs e)
        {
            if (!Char.IsDigit(e.KeyChar) && e.KeyChar != 8 && e.KeyChar != 44) // цифры, клавиша BackSpace и запятая
            {
                e.Handled = true;
            }
        }

        private void TextBox8_KeyPress(object sender, KeyPressEventArgs e)
        {
            if (!Char.IsDigit(e.KeyChar) && e.KeyChar != 8 && e.KeyChar != 44) // цифры, клавиша BackSpace и запятая
            {
                e.Handled = true;
            }
        }

      
    }
}
