using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace Kadr
{
    public partial class SingIn : Form
    {
        public SingIn()
        {
            InitializeComponent();
        }

        private void usersBindingNavigatorSaveItem_Click(object sender, EventArgs e)
        {
            this.Validate();
            this.usersBindingSource.EndEdit();
            this.tableAdapterManager.UpdateAll(this.human_ResourcesDataSet);

        }

        private void SingIn_Load(object sender, EventArgs e)
        {
            // TODO: данная строка кода позволяет загрузить данные в таблицу "human_ResourcesDataSet.Users". При необходимости она может быть перемещена или удалена.
            this.usersTableAdapter.Fill(this.human_ResourcesDataSet.Users);

        }

        private void buttonIn_Click(object sender, EventArgs e)
        {
            DataView dv;
            string login;
            string pass;

            dv = human_ResourcesDataSet.Users.DefaultView;
            login = textBoxLogin.Text;
            pass = textBoxPass.Text;

             dv.RowFilter= string.Format("Логин='{0}' and Пароль='{1}'", login,pass);
            if(dv.Count == 1)
            {
                Hide();
                var main = new FormMain(login);
                main.ShowDialog();
                Close();
            }
            else
                MessageBox.Show("Логин или пароль введены не правильно", "Ошибка", MessageBoxButtons.OK, MessageBoxIcon.Exclamation);
                
            

        }
    }
}
