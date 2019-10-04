# -*- coding: utf-8 -*-

import os, sys
import re
import codecs

try:
    unicode
    import codecs
    sys.stdout = codecs.getwriter('utf-8')(sys.stdout)
    def copen(fname, mode):
        return codecs.open(fname, mode, "utf-8")
except:
    def copen(fname, mode):
        return open(fname, mode, encoding='utf-8')

nuc_dir = "data"

def make_sequence_from_file(fname):
    fname = os.path.join(nuc_dir, fname)
    if not os.path.exists(fname):
        raise Exception("no %s file." % fname)
    last_line = None
    sequence = []
    
    with open(fname, "r", newline='', encoding='utf-8') as f:

        # ファイル読み込み
        s = f.read()
        seq_prev = ""

        # 投稿毎に分割（投稿はCRLF区切り、投稿内容はタブ区切りになっている）
        for line in re.split("\r\n", s):

            #sys.stderr.write("data : %s\n" % (line))

            items = re.split(r"[\t]+", line)

            # 投稿以外の内容を除外
            if len(items) != 3:
                continue

            # 発言内容
            comment = items[2]

            # 不要な改行やクォーテーションを削除
            comment = re.sub("\n"," ",comment)
            comment = re.sub("  "," ",comment)
            comment = comment.lstrip("\"")
            comment = comment.rstrip("\"")

            # 写真やスタンプは除外
            if comment.startswith(("[写真]","[スタンプ]", "[動画]", "[ノート]", "[アルバム]", "[連絡先]", "[ボイスメッセージ]", "[投票]")):
                continue
            
            if items[1] != "田中涼太":
                seq_prev = comment
            else:
                # 誰かの発言に対して田中涼太が発言している組み合わせを記録
                if seq_prev != "":

                    sequence.append((seq_prev, comment))
                    seq_prev = comment
                    #sys.stderr.write("input[%s] : 田中涼太[%s]\n" % (seq_prev, items[2]))
                    #seq_prev = ""
    return sequence

def main():
    
    if not os.path.exists(nuc_dir):
        raise Exception("no extracted files.")

    files = os.listdir(nuc_dir)
    uniq_seq = {}

    with open("sequence.txt", "w", encoding='utf-8') as f_out:

        for f in files:
            if not ".txt" in f:
                continue
            seq = make_sequence_from_file(f)
            # for inp, out in seq:
            #     uniq_seq[inp] = out
        
            for inp, out in seq:
                f_out.write("input: %s\n" % (inp))
                f_out.write("output: %s\n" % (out))
        # for k, v in uniq_seq.items():
        #     f_out.write("input: %s\n" % (k))
        #     f_out.write("output: %s\n" % (v))
            #print("input: %s\noutput: %s" % (k, v))
    
    with open("sequenceT.txt", "w", encoding='utf-8') as f_out:

        for f in files:
            if not ".txt" in f:
                continue
            seq = make_sequence_from_file(f)

            for inp, out in seq:
                f_out.write("%s\t%s\n" % (inp, out))

    with open("sequenceN.txt", "w", encoding='utf-8') as f_out:

        for f in files:
            if not ".txt" in f:
                continue
            seq = make_sequence_from_file(f)

            for inp, out in seq:
                f_out.write("%s\n%s\n\n" % (inp, out))
    return


if __name__ == "__main__":
    main()
    sys.exit(0)
#
