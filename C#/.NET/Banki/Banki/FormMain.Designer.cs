
namespace Banki
{
    partial class FormMain
    {
        /// <summary>
        /// Обязательная переменная конструктора.
        /// </summary>
        private System.ComponentModel.IContainer components = null;

        /// <summary>
        /// Освободить все используемые ресурсы.
        /// </summary>
        /// <param name="disposing">истинно, если управляемый ресурс должен быть удален; иначе ложно.</param>
        protected override void Dispose(bool disposing)
        {
            if (disposing && (components != null))
            {
                components.Dispose();
            }
            base.Dispose(disposing);
        }

        #region Код, автоматически созданный конструктором форм Windows

        /// <summary>
        /// Требуемый метод для поддержки конструктора — не изменяйте 
        /// содержимое этого метода с помощью редактора кода.
        /// </summary>
        private void InitializeComponent()
        {
            this.components = new System.ComponentModel.Container();
            System.ComponentModel.ComponentResourceManager resources = new System.ComponentModel.ComponentResourceManager(typeof(FormMain));
            this.bindingNavigatorBanki = new System.Windows.Forms.BindingNavigator(this.components);
            this.bankBindingSource = new System.Windows.Forms.BindingSource(this.components);
            this.bankiDataSetBindingSource = new System.Windows.Forms.BindingSource(this.components);
            this.bankiDataSet = new Banki.BankiDataSet();
            this.bindingNavigatorCountItem = new System.Windows.Forms.ToolStripLabel();
            this.bindingNavigatorMoveFirstItem = new System.Windows.Forms.ToolStripButton();
            this.bindingNavigatorMovePreviousItem = new System.Windows.Forms.ToolStripButton();
            this.bindingNavigatorSeparator = new System.Windows.Forms.ToolStripSeparator();
            this.bindingNavigatorPositionItem = new System.Windows.Forms.ToolStripTextBox();
            this.bindingNavigatorSeparator1 = new System.Windows.Forms.ToolStripSeparator();
            this.bindingNavigatorMoveNextItem = new System.Windows.Forms.ToolStripButton();
            this.bindingNavigatorMoveLastItem = new System.Windows.Forms.ToolStripButton();
            this.bindingNavigatorSeparator2 = new System.Windows.Forms.ToolStripSeparator();
            this.BankiDataGridView = new System.Windows.Forms.DataGridView();
            this.idDataGridViewTextBoxColumn = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.bIKDataGridViewTextBoxColumn = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.titleDataGridViewTextBoxColumn = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.uRLDataGridViewTextBoxColumn = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.bankTableAdapter = new Banki.BankiDataSetTableAdapters.BankTableAdapter();
            this.buttonEditBank = new System.Windows.Forms.Button();
            this.buttonAddBank = new System.Windows.Forms.Button();
            this.DeleteBankButton = new System.Windows.Forms.Button();
            this.tableAdapterManager = new Banki.BankiDataSetTableAdapters.TableAdapterManager();
            ((System.ComponentModel.ISupportInitialize)(this.bindingNavigatorBanki)).BeginInit();
            this.bindingNavigatorBanki.SuspendLayout();
            ((System.ComponentModel.ISupportInitialize)(this.bankBindingSource)).BeginInit();
            ((System.ComponentModel.ISupportInitialize)(this.bankiDataSetBindingSource)).BeginInit();
            ((System.ComponentModel.ISupportInitialize)(this.bankiDataSet)).BeginInit();
            ((System.ComponentModel.ISupportInitialize)(this.BankiDataGridView)).BeginInit();
            this.SuspendLayout();
            // 
            // bindingNavigatorBanki
            // 
            this.bindingNavigatorBanki.AddNewItem = null;
            this.bindingNavigatorBanki.BindingSource = this.bankBindingSource;
            this.bindingNavigatorBanki.CountItem = this.bindingNavigatorCountItem;
            this.bindingNavigatorBanki.DeleteItem = null;
            this.bindingNavigatorBanki.Items.AddRange(new System.Windows.Forms.ToolStripItem[] {
            this.bindingNavigatorMoveFirstItem,
            this.bindingNavigatorMovePreviousItem,
            this.bindingNavigatorSeparator,
            this.bindingNavigatorPositionItem,
            this.bindingNavigatorCountItem,
            this.bindingNavigatorSeparator1,
            this.bindingNavigatorMoveNextItem,
            this.bindingNavigatorMoveLastItem,
            this.bindingNavigatorSeparator2});
            this.bindingNavigatorBanki.Location = new System.Drawing.Point(0, 0);
            this.bindingNavigatorBanki.MoveFirstItem = this.bindingNavigatorMoveFirstItem;
            this.bindingNavigatorBanki.MoveLastItem = this.bindingNavigatorMoveLastItem;
            this.bindingNavigatorBanki.MoveNextItem = this.bindingNavigatorMoveNextItem;
            this.bindingNavigatorBanki.MovePreviousItem = this.bindingNavigatorMovePreviousItem;
            this.bindingNavigatorBanki.Name = "bindingNavigatorBanki";
            this.bindingNavigatorBanki.PositionItem = this.bindingNavigatorPositionItem;
            this.bindingNavigatorBanki.Size = new System.Drawing.Size(800, 25);
            this.bindingNavigatorBanki.TabIndex = 0;
            this.bindingNavigatorBanki.Text = "bindingNavigatorBanki";
            // 
            // bankBindingSource
            // 
            this.bankBindingSource.DataMember = "Bank";
            this.bankBindingSource.DataSource = this.bankiDataSetBindingSource;
            // 
            // bankiDataSetBindingSource
            // 
            this.bankiDataSetBindingSource.DataSource = this.bankiDataSet;
            this.bankiDataSetBindingSource.Position = 0;
            // 
            // bankiDataSet
            // 
            this.bankiDataSet.DataSetName = "BankiDataSet";
            this.bankiDataSet.SchemaSerializationMode = System.Data.SchemaSerializationMode.IncludeSchema;
            // 
            // bindingNavigatorCountItem
            // 
            this.bindingNavigatorCountItem.Name = "bindingNavigatorCountItem";
            this.bindingNavigatorCountItem.Size = new System.Drawing.Size(43, 22);
            this.bindingNavigatorCountItem.Text = "для {0}";
            this.bindingNavigatorCountItem.ToolTipText = "Общее число элементов";
            // 
            // bindingNavigatorMoveFirstItem
            // 
            this.bindingNavigatorMoveFirstItem.DisplayStyle = System.Windows.Forms.ToolStripItemDisplayStyle.Image;
            this.bindingNavigatorMoveFirstItem.Image = ((System.Drawing.Image)(resources.GetObject("bindingNavigatorMoveFirstItem.Image")));
            this.bindingNavigatorMoveFirstItem.Name = "bindingNavigatorMoveFirstItem";
            this.bindingNavigatorMoveFirstItem.RightToLeftAutoMirrorImage = true;
            this.bindingNavigatorMoveFirstItem.Size = new System.Drawing.Size(23, 22);
            this.bindingNavigatorMoveFirstItem.Text = "Переместить в начало";
            // 
            // bindingNavigatorMovePreviousItem
            // 
            this.bindingNavigatorMovePreviousItem.DisplayStyle = System.Windows.Forms.ToolStripItemDisplayStyle.Image;
            this.bindingNavigatorMovePreviousItem.Image = ((System.Drawing.Image)(resources.GetObject("bindingNavigatorMovePreviousItem.Image")));
            this.bindingNavigatorMovePreviousItem.Name = "bindingNavigatorMovePreviousItem";
            this.bindingNavigatorMovePreviousItem.RightToLeftAutoMirrorImage = true;
            this.bindingNavigatorMovePreviousItem.Size = new System.Drawing.Size(23, 22);
            this.bindingNavigatorMovePreviousItem.Text = "Переместить назад";
            // 
            // bindingNavigatorSeparator
            // 
            this.bindingNavigatorSeparator.Name = "bindingNavigatorSeparator";
            this.bindingNavigatorSeparator.Size = new System.Drawing.Size(6, 25);
            // 
            // bindingNavigatorPositionItem
            // 
            this.bindingNavigatorPositionItem.AccessibleName = "Положение";
            this.bindingNavigatorPositionItem.AutoSize = false;
            this.bindingNavigatorPositionItem.Font = new System.Drawing.Font("Segoe UI", 9F);
            this.bindingNavigatorPositionItem.Name = "bindingNavigatorPositionItem";
            this.bindingNavigatorPositionItem.Size = new System.Drawing.Size(50, 23);
            this.bindingNavigatorPositionItem.Text = "0";
            this.bindingNavigatorPositionItem.ToolTipText = "Текущее положение";
            // 
            // bindingNavigatorSeparator1
            // 
            this.bindingNavigatorSeparator1.Name = "bindingNavigatorSeparator1";
            this.bindingNavigatorSeparator1.Size = new System.Drawing.Size(6, 25);
            // 
            // bindingNavigatorMoveNextItem
            // 
            this.bindingNavigatorMoveNextItem.DisplayStyle = System.Windows.Forms.ToolStripItemDisplayStyle.Image;
            this.bindingNavigatorMoveNextItem.Image = ((System.Drawing.Image)(resources.GetObject("bindingNavigatorMoveNextItem.Image")));
            this.bindingNavigatorMoveNextItem.Name = "bindingNavigatorMoveNextItem";
            this.bindingNavigatorMoveNextItem.RightToLeftAutoMirrorImage = true;
            this.bindingNavigatorMoveNextItem.Size = new System.Drawing.Size(23, 22);
            this.bindingNavigatorMoveNextItem.Text = "Переместить вперед";
            // 
            // bindingNavigatorMoveLastItem
            // 
            this.bindingNavigatorMoveLastItem.DisplayStyle = System.Windows.Forms.ToolStripItemDisplayStyle.Image;
            this.bindingNavigatorMoveLastItem.Image = ((System.Drawing.Image)(resources.GetObject("bindingNavigatorMoveLastItem.Image")));
            this.bindingNavigatorMoveLastItem.Name = "bindingNavigatorMoveLastItem";
            this.bindingNavigatorMoveLastItem.RightToLeftAutoMirrorImage = true;
            this.bindingNavigatorMoveLastItem.Size = new System.Drawing.Size(23, 22);
            this.bindingNavigatorMoveLastItem.Text = "Переместить в конец";
            // 
            // bindingNavigatorSeparator2
            // 
            this.bindingNavigatorSeparator2.Name = "bindingNavigatorSeparator2";
            this.bindingNavigatorSeparator2.Size = new System.Drawing.Size(6, 25);
            // 
            // BankiDataGridView
            // 
            this.BankiDataGridView.AllowUserToAddRows = false;
            this.BankiDataGridView.AllowUserToDeleteRows = false;
            this.BankiDataGridView.AllowUserToOrderColumns = true;
            this.BankiDataGridView.AutoGenerateColumns = false;
            this.BankiDataGridView.ColumnHeadersHeightSizeMode = System.Windows.Forms.DataGridViewColumnHeadersHeightSizeMode.AutoSize;
            this.BankiDataGridView.Columns.AddRange(new System.Windows.Forms.DataGridViewColumn[] {
            this.idDataGridViewTextBoxColumn,
            this.bIKDataGridViewTextBoxColumn,
            this.titleDataGridViewTextBoxColumn,
            this.uRLDataGridViewTextBoxColumn});
            this.BankiDataGridView.DataSource = this.bankBindingSource;
            this.BankiDataGridView.Dock = System.Windows.Forms.DockStyle.Fill;
            this.BankiDataGridView.Location = new System.Drawing.Point(0, 25);
            this.BankiDataGridView.MultiSelect = false;
            this.BankiDataGridView.Name = "BankiDataGridView";
            this.BankiDataGridView.ReadOnly = true;
            this.BankiDataGridView.SelectionMode = System.Windows.Forms.DataGridViewSelectionMode.FullRowSelect;
            this.BankiDataGridView.Size = new System.Drawing.Size(800, 425);
            this.BankiDataGridView.TabIndex = 1;
            // 
            // idDataGridViewTextBoxColumn
            // 
            this.idDataGridViewTextBoxColumn.DataPropertyName = "id";
            this.idDataGridViewTextBoxColumn.HeaderText = "id";
            this.idDataGridViewTextBoxColumn.Name = "idDataGridViewTextBoxColumn";
            this.idDataGridViewTextBoxColumn.ReadOnly = true;
            // 
            // bIKDataGridViewTextBoxColumn
            // 
            this.bIKDataGridViewTextBoxColumn.DataPropertyName = "BIK";
            this.bIKDataGridViewTextBoxColumn.HeaderText = "BIK";
            this.bIKDataGridViewTextBoxColumn.Name = "bIKDataGridViewTextBoxColumn";
            this.bIKDataGridViewTextBoxColumn.ReadOnly = true;
            // 
            // titleDataGridViewTextBoxColumn
            // 
            this.titleDataGridViewTextBoxColumn.AutoSizeMode = System.Windows.Forms.DataGridViewAutoSizeColumnMode.AllCells;
            this.titleDataGridViewTextBoxColumn.DataPropertyName = "Title";
            this.titleDataGridViewTextBoxColumn.HeaderText = "Title";
            this.titleDataGridViewTextBoxColumn.Name = "titleDataGridViewTextBoxColumn";
            this.titleDataGridViewTextBoxColumn.ReadOnly = true;
            this.titleDataGridViewTextBoxColumn.Width = 52;
            // 
            // uRLDataGridViewTextBoxColumn
            // 
            this.uRLDataGridViewTextBoxColumn.AutoSizeMode = System.Windows.Forms.DataGridViewAutoSizeColumnMode.AllCells;
            this.uRLDataGridViewTextBoxColumn.DataPropertyName = "URL";
            this.uRLDataGridViewTextBoxColumn.HeaderText = "URL";
            this.uRLDataGridViewTextBoxColumn.Name = "uRLDataGridViewTextBoxColumn";
            this.uRLDataGridViewTextBoxColumn.ReadOnly = true;
            this.uRLDataGridViewTextBoxColumn.Width = 54;
            // 
            // bankTableAdapter
            // 
            this.bankTableAdapter.ClearBeforeFill = true;
            // 
            // buttonEditBank
            // 
            this.buttonEditBank.BackColor = System.Drawing.Color.CornflowerBlue;
            this.buttonEditBank.Location = new System.Drawing.Point(281, 4);
            this.buttonEditBank.Margin = new System.Windows.Forms.Padding(2);
            this.buttonEditBank.Name = "buttonEditBank";
            this.buttonEditBank.Size = new System.Drawing.Size(26, 20);
            this.buttonEditBank.TabIndex = 10;
            this.buttonEditBank.Text = "=";
            this.buttonEditBank.UseVisualStyleBackColor = false;
            this.buttonEditBank.Click += new System.EventHandler(this.buttonEditBank_Click);
            // 
            // buttonAddBank
            // 
            this.buttonAddBank.BackColor = System.Drawing.Color.Lime;
            this.buttonAddBank.Location = new System.Drawing.Point(218, 4);
            this.buttonAddBank.Name = "buttonAddBank";
            this.buttonAddBank.Size = new System.Drawing.Size(26, 20);
            this.buttonAddBank.TabIndex = 9;
            this.buttonAddBank.Text = "+";
            this.buttonAddBank.UseVisualStyleBackColor = false;
            this.buttonAddBank.Click += new System.EventHandler(this.buttonAddBank_Click);
            // 
            // DeleteBankButton
            // 
            this.DeleteBankButton.Image = ((System.Drawing.Image)(resources.GetObject("DeleteBankButton.Image")));
            this.DeleteBankButton.Location = new System.Drawing.Point(250, 4);
            this.DeleteBankButton.Name = "DeleteBankButton";
            this.DeleteBankButton.Size = new System.Drawing.Size(26, 21);
            this.DeleteBankButton.TabIndex = 8;
            this.DeleteBankButton.Text = "X";
            this.DeleteBankButton.UseVisualStyleBackColor = true;
            this.DeleteBankButton.Click += new System.EventHandler(this.buttonDeleteBank_Click);
            // 
            // tableAdapterManager
            // 
            this.tableAdapterManager.BackupDataSetBeforeUpdate = false;
            this.tableAdapterManager.BankTableAdapter = this.bankTableAdapter;
            this.tableAdapterManager.UpdateOrder = Banki.BankiDataSetTableAdapters.TableAdapterManager.UpdateOrderOption.InsertUpdateDelete;
            // 
            // FormMain
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size(800, 450);
            this.Controls.Add(this.buttonEditBank);
            this.Controls.Add(this.buttonAddBank);
            this.Controls.Add(this.DeleteBankButton);
            this.Controls.Add(this.BankiDataGridView);
            this.Controls.Add(this.bindingNavigatorBanki);
            this.Name = "FormMain";
            this.Text = "Banki";
            this.Load += new System.EventHandler(this.Form1_Load);
            ((System.ComponentModel.ISupportInitialize)(this.bindingNavigatorBanki)).EndInit();
            this.bindingNavigatorBanki.ResumeLayout(false);
            this.bindingNavigatorBanki.PerformLayout();
            ((System.ComponentModel.ISupportInitialize)(this.bankBindingSource)).EndInit();
            ((System.ComponentModel.ISupportInitialize)(this.bankiDataSetBindingSource)).EndInit();
            ((System.ComponentModel.ISupportInitialize)(this.bankiDataSet)).EndInit();
            ((System.ComponentModel.ISupportInitialize)(this.BankiDataGridView)).EndInit();
            this.ResumeLayout(false);
            this.PerformLayout();

        }

        #endregion

        private System.Windows.Forms.BindingNavigator bindingNavigatorBanki;
        private System.Windows.Forms.ToolStripLabel bindingNavigatorCountItem;
        private System.Windows.Forms.ToolStripButton bindingNavigatorMoveFirstItem;
        private System.Windows.Forms.ToolStripButton bindingNavigatorMovePreviousItem;
        private System.Windows.Forms.ToolStripSeparator bindingNavigatorSeparator;
        private System.Windows.Forms.ToolStripTextBox bindingNavigatorPositionItem;
        private System.Windows.Forms.ToolStripSeparator bindingNavigatorSeparator1;
        private System.Windows.Forms.ToolStripButton bindingNavigatorMoveNextItem;
        private System.Windows.Forms.ToolStripButton bindingNavigatorMoveLastItem;
        private System.Windows.Forms.ToolStripSeparator bindingNavigatorSeparator2;
        private System.Windows.Forms.BindingSource bankiDataSetBindingSource;
        private System.Windows.Forms.Button buttonEditBank;
        private System.Windows.Forms.Button buttonAddBank;
        private System.Windows.Forms.Button DeleteBankButton;
        private System.Windows.Forms.DataGridViewTextBoxColumn idDataGridViewTextBoxColumn;
        private System.Windows.Forms.DataGridViewTextBoxColumn bIKDataGridViewTextBoxColumn;
        private System.Windows.Forms.DataGridViewTextBoxColumn titleDataGridViewTextBoxColumn;
        private System.Windows.Forms.DataGridViewTextBoxColumn uRLDataGridViewTextBoxColumn;
        public BankiDataSet bankiDataSet;
        public System.Windows.Forms.BindingSource bankBindingSource;
        public BankiDataSetTableAdapters.BankTableAdapter bankTableAdapter;
        public System.Windows.Forms.DataGridView BankiDataGridView;
        public BankiDataSetTableAdapters.TableAdapterManager tableAdapterManager;
    }
}

