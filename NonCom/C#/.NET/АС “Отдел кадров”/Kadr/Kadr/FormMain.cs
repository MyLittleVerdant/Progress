using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;
using KadrLib.Exception;
using System.Configuration;
using System.Data.SqlClient;

namespace Kadr
{
    public partial class FormMain : Form
    {
        
        public FormMain(string user)
        {
           
            InitializeComponent();

            if (user == "user")
            {
                //
                panelEmployee.Visible = false;
                bindingNavigatorDeleteItem.Visible = false;
                bindingNavigatorSaveEmployee.Visible = false;

                //
                panelContract.Visible = false;
                bindingNavigatorDeleteItem1.Visible = false;
                bindingNavigatorSaveContract.Visible = false;

                //
                panelHistory.Visible = false;
                bindingNavigatorDeleteItem2.Visible = false;
                bindingNavigatorSaveHistory.Visible = false;

                //
                panelSchedule.Visible = false;
                bindingNavigatorDeleteItem3.Visible = false;
                bindingNavigatorSaveSchedule.Visible = false;

            }
        }

        private void employeeBindingNavigatorSaveItem_Click(object sender, EventArgs e)
        {
            this.Validate();
            this.employeeBindingSource.EndEdit();
            this.tableAdapterManager.UpdateAll(this.human_ResourcesDataSet);

        }

        private void Form1_Load(object sender, EventArgs e)
        {
            // TODO: данная строка кода позволяет загрузить данные в таблицу "human_ResourcesDataSet.Post". При необходимости она может быть перемещена или удалена.
            this.postTableAdapter.Fill(this.human_ResourcesDataSet.Post);
            // TODO: данная строка кода позволяет загрузить данные в таблицу "human_ResourcesDataSet.Department". При необходимости она может быть перемещена или удалена.
            this.departmentTableAdapter.Fill(this.human_ResourcesDataSet.Department);
            // TODO: данная строка кода позволяет загрузить данные в таблицу "human_ResourcesDataSet.Education". При необходимости она может быть перемещена или удалена.
            this.educationTableAdapter.Fill(this.human_ResourcesDataSet.Education);
            // TODO: данная строка кода позволяет загрузить данные в таблицу "human_ResourcesDataSet.Staff_schedule". При необходимости она может быть перемещена или удалена.
            this.staff_scheduleTableAdapter.Fill(this.human_ResourcesDataSet.Staff_schedule);
            // TODO: данная строка кода позволяет загрузить данные в таблицу "human_ResourcesDataSet.Working_history". При необходимости она может быть перемещена или удалена.
            this.working_historyTableAdapter.Fill(this.human_ResourcesDataSet.Working_history);
            // TODO: данная строка кода позволяет загрузить данные в таблицу "human_ResourcesDataSet.Employment_contract". При необходимости она может быть перемещена или удалена.
            this.employment_contractTableAdapter.Fill(this.human_ResourcesDataSet.Employment_contract);
            // TODO: данная строка кода позволяет загрузить данные в таблицу "human_ResourcesDataSet.Employee". При необходимости она может быть перемещена или удалена.
            this.employeeTableAdapter.Fill(this.human_ResourcesDataSet.Employee);

            this.reportViewerEmployee.RefreshReport();

            this.reportViewerSchedule.RefreshReport();
        }

        private void buttonFindEmployee_Click(object sender, EventArgs e)
        {
            try
            {
                DataView dv;
                string col;
                string value;
                if(comboBoxEmployee.SelectedItem == null)
                {
                    throw new KadrLib.Exception.Exception("Не выбраны значения");
                }
                if(textBoxEmployee.Text=="")
                {
                    throw new KadrLib.Exception.Exception("Не выбраны значения");
                }
                dv = human_ResourcesDataSet.Employee.DefaultView;
                if (comboBoxEmployee.SelectedIndex == 0)
                    col = "Фамилия";
                else if (comboBoxEmployee.SelectedIndex == 1)
                    col = "Имя";
                else
                    col = "Отчество";
                value = textBoxEmployee.Text;
                dv.RowFilter = string.Format("{0}='{1}'", col, value);
                employeeDataGridView.DataSource = dv;
            }
            catch (System.Exception exception)
            {
                
                MessageBox.Show(exception.Message,"Ошибка", MessageBoxButtons.OK, MessageBoxIcon.Exclamation);
            }

            
        }

        private void buttonAllEmployee_Click(object sender, EventArgs e)
        {
            employeeDataGridView.DataSource = employeeBindingSource;
            

        }

        private void buttonFindContract_Click(object sender, EventArgs e)
        {

            try
            {
                DataView dv;
                string col;
                string value;

                dv = human_ResourcesDataSet.Employment_contract.DefaultView;
                if (comboBoxContract.SelectedIndex == 0)
                    col = "Сотрудник";
                else if (comboBoxContract.SelectedIndex == 1)
                    col = "Отдел";
                else
                    col = "Должность";
                value = textBoxContract.Text;
                dv.RowFilter = string.Format("{0}='{1}'", col, value);
                employment_contractDataGridView.DataSource = dv;
            }
            catch (System.Exception exception)
            {
                MessageBox.Show("Не выбраны значения", "Ошибка", MessageBoxButtons.OK, MessageBoxIcon.Exclamation);
                
            }
            
      
        }

        private void buttonAllContract_Click(object sender, EventArgs e)
        {
            employment_contractDataGridView.DataSource = employment_contractBindingSource;
        }

        private void buttonFindHistory_Click(object sender, EventArgs e)
        {
            try
            {
                DataView dv;
                string col;
                string value;

                dv = human_ResourcesDataSet.Working_history.DefaultView;
                if (comboBoxHistory.SelectedIndex == 0)
                    col = "Стаж";
                else if (comboBoxHistory.SelectedIndex == 1)
                    col = "Предприятие";
                else
                    col = "Сотрудник";
                value = textBoxHistory.Text;
                dv.RowFilter = string.Format("{0}='{1}'", col, value);
                working_historyDataGridView.DataSource = dv;
            }
            catch(System.Exception exception)
            {
                MessageBox.Show("Не выбраны значения", "Ошибка", MessageBoxButtons.OK, MessageBoxIcon.Exclamation);
            }
            
        }

        private void buttonAllHistory_Click(object sender, EventArgs e)
        {
            working_historyDataGridView.DataSource = working_historyBindingSource;
        }

        private void buttonFindSchedule_Click(object sender, EventArgs e)
        {
            try
            {
                DataView dv;
                string col;
                string value;

                dv = human_ResourcesDataSet.Staff_schedule.DefaultView;
                if (comboBoxSchedule.SelectedIndex == 0)
                    col = "[Количество ставок]";
                else if (comboBoxSchedule.SelectedIndex == 1)
                    col = "Оклад";
                else
                    col = "Надбавка";
                value = textBoxSchedule.Text;
                dv.RowFilter = string.Format("{0}='{1}'", col, value);
                staff_scheduleDataGridView.DataSource = dv;
            }catch(System.Exception exception)
            {
                MessageBox.Show("Не выбраны значения", "Ошибка", MessageBoxButtons.OK, MessageBoxIcon.Exclamation);
            }
            
        }

        private void buttonAllSchedule_Click(object sender, EventArgs e)
        {
            staff_scheduleDataGridView.DataSource = staff_scheduleBindingSource;
        }

        private void bindingNavigatorSaveItem_Click(object sender, EventArgs e)
        {
            this.Validate();
            this.employeeBindingSource.EndEdit();
            this.tableAdapterManager.UpdateAll(this.human_ResourcesDataSet);
        }

        private void bindingNavigatorSaveContract_Click(object sender, EventArgs e)
        {
            this.Validate();
            this.employment_contractBindingSource.EndEdit();
            this.tableAdapterManager.UpdateAll(this.human_ResourcesDataSet);
        }

        private void bindingNavigatorSaveHistory_Click(object sender, EventArgs e)
        {
            this.Validate();
            this.working_historyBindingSource.EndEdit();
            this.tableAdapterManager.UpdateAll(this.human_ResourcesDataSet);
        }

        private void buttonAddSchedule_Click(object sender, EventArgs e)
        {
            try
            {
                DataRow Row = human_ResourcesDataSet.Staff_schedule.NewRow();
                Row[1] = numericUpDownBid.Value;
                Row[2] = numericUpDownPayment.Value;
                Row[3] = numericUpDownExtra.Value;
                if(numericUpDownBid.Value==0)
                {
                    throw new KadrLib.Exception.Exception("Поле 'Кол-во ставок' должно быть > 0 ");
                }else if(numericUpDownPayment.Value==0)
                {
                    throw new KadrLib.Exception.Exception("Поле 'Оклад' должно быть > 0 ");
                }

                human_ResourcesDataSet.Staff_schedule.Rows.Add(Row);
                tableAdapterManager.UpdateAll(human_ResourcesDataSet);
                human_ResourcesDataSet.AcceptChanges();
            }catch(System.Exception exception)
            {
                MessageBox.Show(exception.Message, "Ошибка", MessageBoxButtons.OK, MessageBoxIcon.Exclamation);
                
            }
        }

        private void bindingNavigatorSaveSchedule_Click(object sender, EventArgs e)
        {
            this.Validate();
            this.staff_scheduleBindingSource.EndEdit();
            this.tableAdapterManager.UpdateAll(this.human_ResourcesDataSet);
        }

        private void buttonAddHistory_Click(object sender, EventArgs e)
        {
            DataRow Row = human_ResourcesDataSet.Working_history.NewRow();
            Row[1] = textBoxPrevPost.Text;
            Row[2] = numericUpDownExp.Value;
            Row[3] = textBoxCompany.Text;
           Row[4] = comboBoxEmployee2.SelectedValue;
           

            human_ResourcesDataSet.Working_history.Rows.Add(Row);
            tableAdapterManager.UpdateAll(human_ResourcesDataSet);
            human_ResourcesDataSet.AcceptChanges();
        }

        private void buttonAddContract_Click(object sender, EventArgs e)
        {
            DataRow Row = human_ResourcesDataSet.Employment_contract.NewRow();
            Row[1] = dateTimePicker.Value;
            Row[2] = comboBoxEmployee1.SelectedValue;
            Row[3] = comboBoxDepartment.SelectedValue;
            Row[4] = comboBoxPost.SelectedValue;
            Row[5] = comboBoxSchedule2.SelectedValue;


            human_ResourcesDataSet.Employment_contract.Rows.Add(Row);
            tableAdapterManager.UpdateAll(human_ResourcesDataSet);
            human_ResourcesDataSet.AcceptChanges();
        }

        private void buttonAddEmployee_Click(object sender, EventArgs e)
        {
            try
            {
                if (textBoxSname.Text == "")
                {
                    throw new KadrLib.Exception.Exception("Поле 'Фамилия' не должно быть пустым");
                }
                if (textBoxName.Text == "")
                {
                    throw new KadrLib.Exception.Exception("Поле 'Имя' не должно быть пустым");
                }
                if (comboBoxGender.SelectedItem == null)
                {
                    throw new KadrLib.Exception.Exception("Не выбран пол");
                }
                if (maskedTextBoxINN.Text.Length <12)
                {
                    throw new KadrLib.Exception.Exception("Не верно введен ИНН");
                }
                if (textBoxAddress.Text == "")
                {
                    throw new KadrLib.Exception.Exception("Поле 'Адрес' не должно быть пустым");
                }
                if (textBoxShip.Text == "")
                {
                    throw new KadrLib.Exception.Exception("Поле 'Семейное положение' не должно быть пустым");
                }

                DataRow Row = human_ResourcesDataSet.Employee.NewRow();
                Row[1] = textBoxSname.Text;
                Row[2] = textBoxName.Text;
                Row[3] = textBoxMname.Text;
                Row[4] = dateTimePickerDoB.Value;
                Row[5] = comboBoxGender.SelectedItem;
                Row[6] = maskedTextBoxINN.Text;
                Row[7] = maskedTextBoxPhone.Text;
                Row[8] = textBoxAddress.Text;
                Row[9] = comboBoxEducation.SelectedValue;
                Row[10] = textBoxShip.Text;



                human_ResourcesDataSet.Employee.Rows.Add(Row);
                tableAdapterManager.UpdateAll(human_ResourcesDataSet);
                human_ResourcesDataSet.AcceptChanges();
            }
            catch(System.Exception exception)
            {
                MessageBox.Show(exception.Message, "Ошибка", MessageBoxButtons.OK, MessageBoxIcon.Exclamation);
            }

        }

        private void buttonGenderSort_Click(object sender, EventArgs e)
        {
            try
            {
                if (comboBoxSortGender.SelectedItem == null)
                    throw new KadrLib.Exception.Exception("Не выбран гендер");
                employeeTableAdapter1.FillByGender(human_ResourcesDataSet.Employee, comboBoxSortGender.SelectedItem.ToString());

            }
            catch (System.Exception exception)
            {
                MessageBox.Show(exception.Message, "Ошибка", MessageBoxButtons.OK, MessageBoxIcon.Exclamation);

            }
        }

        

        private void buttonStopSort_Click(object sender, EventArgs e)
        {
            this.employeeTableAdapter.Fill(this.human_ResourcesDataSet.Employee);
        }

     
    }
}
